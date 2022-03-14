const fileLoadInputs = {};




const fileLoader = {
    fileLoaderBlock: '.js_file-loader',
    proxyInput: '.js_file-loader__proxy',
    fileInput: '.js_file-loader__input',
    previewBlock: '.js_images-preview',
    prefix: 'fileLoader',
    rules: {
        'limit': '1',
        'size': '10000'
    },
    init() {

        document.addEventListener('DOMContentLoaded', () => {

            document.querySelectorAll(fileLoader.proxyInput).forEach((control, inx) => {

                // Вешаем обработчик на событие клик
                control.addEventListener('click', this.openChooseFile);

                // Получаем реальный инпут
                const realInput = fileLoader.getProxyInputFromData(control);

                // Инициализируем хранение объекта и получаем хэш
                const hash = fileLoader.beforeInit(inx, control);

                // Вешаем обработчик на загрузку файла
                realInput.addEventListener('change', function (e) {

                    // Создаём глобальный объект для хранения состояний
                    //const hash = fileLoader.initWindowHash(inx, el);

                    if ('rules' in control.dataset) {
                        fileLoader.addToTmp(control, JSON.parse(control.dataset.rules), hash);
                    } else {
                        //fileLoader.addToTmp(e, fileLoader.rules);
                    }

                });
            });
        });

    },
    beforeInit(inx, el){
        let limitRule = 0
        let hash = `${fileLoader.prefix}_${inx}`;

        // Получаем подительскую обёртку для превью
        const previewBlock = el.closest('.js_thumbs')

        // Проверяем есть ли элементы
        const previewItems = previewBlock.querySelectorAll('.js_images-preview__item')
        if(previewItems) {
            // Добавляем хэш, для дальнейшего использования
            previewBlock.dataset.hash = hash
            // Количество сущь. файлов
            limitRule = previewItems.length

        }

        if (!fileLoadInputs.hasOwnProperty(hash)) {
            fileLoadInputs[hash] = {
                limit_rule: limitRule,
                files: {}
            }

        }
        return hash

    },
    initWindowHash(inx, el) {

        let hash = `${fileLoader.prefix}_${inx}`;
        if (!fileLoadInputs.hasOwnProperty(hash)) {
            fileLoadInputs[hash] = {'limit_rule': 0};
            fileLoadInputs[hash] = {'files': {}};
        }

        return hash;
    },

    getRealFileInput(input) {
        return input.closest('.js_file-loader').querySelector('.js_file-loader__input');
    },
    getPreviewBlock(actionSvg) {
        return actionSvg.closest('.js_thumbs');
    },
    getInputPreviewBlock(input) {
        //return input.closest('.js_file-loader').querySelector('.js_thumbs__previews');
        return input.closest('.js_file-loader').querySelector('.js_images-preview');
    },
    getProxyInputFromData(input) {
        return (document).querySelector(`.${input.dataset.proxy}`);
    },

    removeNotice(el = false) {
        // console.log('removeNotice');
        // const inputInput = el || document.querySelector('.js_fileInput')
        // if (inputInput.nextElementSibling)
        //     inputInput.nextElementSibling.classList.remove('show')
    },
    openChooseFile(e) {
        const proxyInput = fileLoader.getProxyInputFromData(e.target);
        proxyInput.click();
    },
    addToTmp(control, rules, hash) {
        const realInput = fileLoader.getProxyInputFromData(control);

        if ('files' in realInput) {
            const files = realInput.files;
            let valid = true;

            // Убераем ошибки если есть
            //fileLoader.removeNotice(realInput);

            for (let i = 0; i < files.length; i++) {
                // валидируем (количество, типы, размер)
                for (let code in rules) {

                    // выводим ошибки если есть
                    if (!validator.hasOwnProperty(code)) continue;

                    if (!validator[code].call(files[i], rules[code], hash)) {
                        valid = false;
                        break;
                    }
                }

                // Добавление в тмп
                if (valid) fileLoader.addToValidArray(realInput, control, files[i], hash);
            }
        }
    },

    addToValidArray(realInput, control, file, hash) {

        if (fileLoadInputs[hash]['files'].hasOwnProperty(file.name)) return

        fileLoadInputs[hash]['files'][file.name] = file;
        fileLoader.renderFilePreview(file, control, hash);
        fileLoader.addFilesListToInput(realInput, hash);

    },


    // Отмечаем файл как главный
    setAsMain(el, name = null){

            if (el.parentElement) {
                const notMain = el.parentElement.querySelectorAll('.js_images-preview__item')
                if (notMain.length)
                    notMain.forEach(item => {
                        item.classList.remove('image_main')
                    })
            }
            el.classList.add('image_main')
            document.querySelector('input#main_image').value = name

    },


    renderFilePreview(file, control, inputHash) {
        console.log(file, control, inputHash);
        const previewList = fileLoader.getInputPreviewBlock(control);
        const hash = md5(file.name);
        const ext = file.name.split('.').pop();

        const previewItem = `
            <div class="js_images-preview__item images-preview__item" onclick="fileLoader.setAsMain(this, '${hash}.${ext}')">
                <img class="images-preview__img" src="${URL.createObjectURL(file)}" alt="">
                <div class="file-loader__bottom">
                    <span class="images-preview__name">${file.name}</span>
                    <svg onclick="event.stopPropagation(); fileLoader.removeFromArray(this)" 
                    data-name="${file.name}" 
                    data-hash="${inputHash}"
                    class="images-preview__del file-loader__del js_file-loader__del">
                        <use xlink:href="/images/icons.svg#icon-close"></use>
                    </svg>
                    
                </div>    
                <div class="image-preview__process">
                    <div class="_image-preview__bar"></div>       
                </div>
            </div>
            `;
        previewList.insertAdjacentHTML('afterbegin', previewItem);
    },



    removeFromArray(svg) {

        let inputHash = svg.dataset.hash || fileLoader.getPreviewBlock(svg).dataset.hash
        const name = svg.dataset.name;

        // Проверяем если это сущ. файл то добавляем в инпут на удаление
        if(svg.classList.contains('js_old__file')){
            fileLoader.addFileToDelete(svg)
        }

        // Получаем родителя блока для доступа в реальному инпуту
        const fileLoaderBlock = svg.closest(`${fileLoader.fileLoaderBlock}`);
        const proxyInput = fileLoaderBlock.querySelector(`${fileLoader.proxyInput}`)
        const realInput = fileLoader.getProxyInputFromData(proxyInput)


        // После удаления временного файла удаляем из инпута
        const dt = new DataTransfer();
        Array.prototype.forEach.call(realInput.files, (file, inx) => {
            if(file.name !== name){
                dt.items.add(file)
            }
        })
        realInput.files = dt.files;

        // Удаляем из глобального массива
        if (fileLoadInputs[inputHash]['files'].hasOwnProperty(name)) {
            delete fileLoadInputs[inputHash]['files'][name];
        }

        // Удаляем teg
        svg.closest('.js_images-preview__item').remove();
        fileLoadInputs[inputHash]['limit_rule'] -= 1;

    },


    // Создаём объект и добавляем в инпут
    addFilesListToInput(input, hash) {

        const dt = new DataTransfer();
        for (key in fileLoadInputs[hash]['files']) {

            dt.items.add(fileLoadInputs[hash]['files'][key]);
        }
        input.files = dt.files;
        //console.log(input.files);
    },


    // Выводим сообщение об ошибках
    showNotice(el, msg) {
        let errorElement = el.closest('.js_file-loader').querySelector('.js_file-loader__error');
        errorElement.classList.add('show');
        errorElement.innerHTML = msg;
    },

    addFileToDelete(element){
        const delInputClass = element.dataset.delInput
        const fileId = element.dataset.fileId
        const delInput = document.querySelector(`.${delInputClass}`)

        if(delInput.value.includes(fileId)) return

        if(delInput.value === '')
            delInput.value = fileId
        else {
            delInput.value += `,${fileId}`
        }


    }



};


const validator = {

    massages: {
        'limit': 'Максимальное количество файлов ',
        'size': 'Максимальный размер файла ',
        'types': 'Допустимые форматы '
    },

    limit(val, hash) {


        let {limit_rule: curVal = 0} = fileLoadInputs[hash];

        console.log(curVal, Number(val));
        if (curVal === 0) {
            fileLoadInputs[hash]['limit_rule'] = 1;
            return true;
        }
        if (Number(curVal) >= Number(val)) {
            alert(`${validator['massages']['limit']} ${val}`);
            //showNotice(element, validator.massages['limit'] + val);
            return false;
        }
        fileLoadInputs[hash]['limit_rule'] = ++curVal;

        return true;
    },

    // size( element, val){
    //    // console.log('size', this, val);
    //     validator.setData(element, 'size', 1500)
    //     console.log(validator.getData(element));
    //     return true
    // },
    // type(element, val){
    //    // console.log('type', this, val);
    //     validator.setData(element, 'type', 'jpeg')
    //     console.log(validator.getData(element));
    //     return true
    //
    // }
};


fileLoader.init();