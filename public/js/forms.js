//==================================
//====================ПОДКЛЮЧЁН ТОЛЬКО В АДМИНКЕ


document.addEventListener("DOMContentLoaded", () => {
//window.onload=function(){
    let imgInput = document.querySelector('.single-img__input')
    if (imgInput) {
        imgInput.addEventListener('change', function (e) {
            formsFile.init(this, 'post-image', true);
        })
    }

    // Отправка формы
    let form = document.querySelector('.create-form')
    if (form) form.addEventListener('submit', function (e) {
        formsFile.formSubmit(this.getAttribute('action'), e)
    })

    // Обновить время подняния поста
    let postUpBtn = document.querySelector('.js_postUp')
   if(postUpBtn) postUpBtn.addEventListener('click', postUp)

    // fake click
    let fakeUpload = document.querySelector('.fake-upload')
        if(fakeUpload) fakeUpload.addEventListener('click', ()=>{
        imgInput.click()
    })
})

const tmpForMultipleFiles = [];

const formsFile = {
    submit: null,
    count: null,
    multiple: false,
    files: [],
    input: null,
    sendFiles: [],
    // Инициализация
    j(el) {
        console.log(el)
    },
    init(input, formId, multiple) {

        let newFiles = document.querySelectorAll('.js_newImgItem')
            .forEach((ele) => {
                if (ele) formsFile.removeFile(ele.querySelector('.image-preview__del'))
            });


        formsFile.multiple = multiple
        formsFile.input = input
        formsFile.count = Number(input.getAttribute('data-count'));
        let form = document.getElementById(formId)
        formsFile.submit = form.querySelector('button[type="submit"]')
        if (multiple) {
            formsFile.files = input.files
        } else {
            formsFile.files = []
            formsFile.sendFiles = []
            formsFile.files = input.files[0]
        }
        formsFile.fileLoad(input)

    },
    // Отправка фомы
    formSubmit(url, e) {
        //e.preventDefault()
        console.log(tmpForMultipleFiles)
        return false;
        // if (formsFile.sendFiles) {
        //     let formData = new FormData();
        //     for (let f in formsFile.sendFiles) {
        //         formData.append("images[]", formsFile.sendFiles[f]);
        //     }
        //     axios.post(url,
        //         formData, {
        //             headers: {
        //                 'Content-Type': 'multipart/form-data'
        //             }
        //         }).then(function (response) {
        //         console.log(response)
        //     })
        // }
    },
    // Вывод превьюшек
    showUploadedItem(source, file) {
        let previewList = document.querySelector(".image-preview"),
           fakeUpload = document.querySelector(".fake-upload"),
            hash = md5(file.name),
            ext = file.name.split('.').pop(),
            previewItem = `
                <div class="js_newImgItem image-preview__item" onclick="setAsMain(this, '${hash}.${ext}')">
                    <img src="${source}" alt="">
                    <span class="image-preview__name">${file.name}</span>
                    <svg onclick="formsFile.removeFile(this)" data-name="${file.name}" class="image-preview__del">
                        <use xlink:href="/images/icons.svg#icon-close"></use>
                    </svg>
                    <div class="image-preview__process">
                        <div class="image-preview__bar"></div>
                    </div>
                </div>
            `;
        console.log(file)
        //if (formsFile.multiple) previewList.innerHTML += previewItem;
        if (formsFile.multiple) fakeUpload.insertAdjacentHTML('beforebegin', previewItem);
        else previewList.innerHTML = previewItem;
    },
    // Вополняем после загрузки файла
    fileLoad(input) {
        if (formsFile.files.length) {
            formsFile.removeNotice(input);
            let valid = true
            // Перебераем загруженные файлы
            Array.from(formsFile.files).forEach((el) => {
                let currentFile = el;
                // Применяем правила валидации в файлу
                for (let code in formsFile.validateRule) {
                    if (!formsFile.validateRule[code].call(el, el, input)) {
                        valid = false;
                        input.value = ""
                        break;
                    }
                }
                // Если файл прошёл валидацию
                if (valid) {
                    formsFile.count += 1
                    formsFile.input.setAttribute('data-count', formsFile.count);


                    let reader = new FileReader();

                    // ToDo: сделать сататус заугрузки
                    // reader.onloadstart = formsFile.updateProgress;
                    // reader.onprogress = formsFile.updateProgress;
                    // reader.onloadend = formsFile.updateProgress;

                    reader.onload = (el) => {
                        // Добавляем в дом загруженный файл, проверяем на дубли
                        if (!formsFile.sendFiles[currentFile.name])
                            formsFile.showUploadedItem(reader.result, currentFile);
                        // Добавляем в финальный массив файл
                        formsFile.sendFiles[currentFile.name] = currentFile;
                        tmpForMultipleFiles.push(currentFile)
                    }
                    reader.readAsDataURL(el);
                }
            })
        }
    },
    updateProgress(evt) {
        //имитируем процесс загрузки файла
        if (evt.lengthComputable) {
            if(evt.loaded == evt.total)
            //let progress =  (evt.loaded / evt.total) * 100;
            console.log(evt.loaded);
            //console.log(evt.total);
            // let i = 0;
            // let progressId = setInterval(function() {
            //     i++;
            //     barFile.value = i * 10;
            //     if (i > 10) clearInterval(progressId);
            // }, evt.total / 300000);
        }
    },

    // Удаление файлов
    removeFile(el) {
        if (!formsFile.input) {
            formsFile.input = document.querySelector('.single-img__input');
        }
        formsFile.count = formsFile.count || Number(formsFile.input.getAttribute('data-count'));

        // Получаем значения индекс
        let inx = el.getAttribute('data-name')
        // Удаляем из массива для передачи на бэкенд
        delete formsFile.sendFiles[inx]

        // Удаляем дом элемент
        el.parentElement.remove()
        formsFile.count -= 1
        //formsFile.removeNotice(formsFile.input);
        formsFile.input.setAttribute('data-count', formsFile.count);
        formsFile.removeNotice(formsFile.input);

        // ID элемента на удалени
        let toDel = el.getAttribute('data-to-del');

        // Значение для удаления
        let deleteIds = document.getElementById('delete_ids');
        let allIds = []
        if(!deleteIds.value){
            allIds.push(toDel)
        }else{
            allIds = JSON.parse(deleteIds.value);
            allIds.push(toDel)
        }
        $(deleteIds).val(JSON.stringify( allIds ))







    },
    // Запрещаем или разрешаем отправку формы
    formStatus(status) {
        if (!status) formsFile.submit.disabled = true;
        else formsFile.submit.disabled = false;
    },
    // Правили валидации
    validateRule: {
        limit: (file, el) => {
            let msg = 'Максимальное количество файлов 5';
            if (Object.keys(formsFile.sendFiles).length + 1 > 5 ||
                formsFile.input.files.length > 5 ||
                formsFile.count + 1 > 5
            ) {
                formsFile.showNotice(el, msg)
                return false
            }
            return true
        },
        size: (file, el) => {
            let msg = 'Максимальный размер 2 мб';
            if (file.size > 1024 * 1024 * 2) {
                formsFile.showNotice(el, msg)
                return false
            }
            return true
        },
        type: (file, el) => {
            let allowTypes = ['jpg', 'jpeg', 'png'],
                msg = `Разрешены только следующие типы ${allowTypes.join(', ')}`;
            //console.log(file)
            let fileExtension = file.type.split("/").pop();
            if (!allowTypes.includes(fileExtension)) {
                formsFile.showNotice(el, msg)
                return false
            }
            return true
        }
    },
    // Убераем сообщения об ошибках
    removeNotice(el) {
        if (el.nextSibling)
            el.nextElementSibling.classList.remove('show')
    },
    // Выводим сообщение об ошибках
    showNotice(el, msg) {
        let errorElement = el.nextElementSibling
        errorElement.classList.add("show")
        errorElement.innerHTML = msg
    }
};


// Отмечаем файл как главный
function setAsMain(el, name = null) {
    el.parentElement.querySelectorAll('.image-preview__item').forEach(item => {
        item.classList.remove('image_main')
    })
    el.classList.add('image_main')
    document.querySelector('input#main_image').value = name
}


function postUp(e) {
    let postId = this.getAttribute('data-id'),
        postUpMsg = this.previousElementSibling
    if (postId) {
        axios.post(
            '/profile/ads/update',
            {id: postId},
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }
        ).then(function (response) {
            console.log(postUpMsg)
            postUpMsg.innerHTML = response.data
        }).catch(error => {
            console.log(error);
        })
    }
    //this.setAttribute('disabled', !this.getAttribute('disabled'))
    e.preventDefault()
}


