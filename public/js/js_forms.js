document.addEventListener("DOMContentLoaded", () => {
    const  imgInput = document.querySelector('.js_fileInput')
    if (imgInput) {
        imgInput.addEventListener('change', function (e) {
            addToTmp(e)
        })
    }

    // Обновить время подняния поста
    let postUpBtn = document.querySelector('.js_postUp')
    if(postUpBtn) postUpBtn.addEventListener('click', postUp)

    // fake click
    let fakeUpload = document.querySelector('.fake-upload')
    if(fakeUpload) fakeUpload.addEventListener('click', ()=>{
        imgInput.click()
    })

    // Если форма редактирования
    let editingImages = document.querySelectorAll('.image-preview__item')
    if(editingImages.length > 0){
        editingImages.forEach(el => {
            tmpForMultipleFiles[el.querySelector('.image-preview__name').innerHTML] = 'old'
            //editingImagesNames.push(el.querySelector('input[name="old_files[]"]').value)
        })
    }
})

const editingImagesNames = []

const tmpForMultipleFiles = {};
const addToTmp = function (e) {
    if ('files' in e.target) {
        let files = e.target.files, valid = true
        // Убераем ошибки если есть
        removeNotice(e.target)
        for(let i = 0; i < files.length; i++){
            // валидируем (количество, типы, размер)
            for (let code in validateRule) {
                // выводим ошибки если есть
                if (!validateRule[code].call(files[i], files[i],  e.target)) {
                    valid = false;
                    break;
                }
            }
            // Добавление в тмп
            if(valid) addToValidArray(files[i])
        }
    }
    console.log(tmpForMultipleFiles)
}
const removeFromArray = (element) => {
    const name = element.previousElementSibling.innerHTML
    if(tmpForMultipleFiles.hasOwnProperty(name)) {
        if(tmpForMultipleFiles[name] == 'old')
            addToBeDelete(element)
        delete tmpForMultipleFiles[name]
    }
    element.parentElement.remove()
    removeNotice()
    addFilesListToInput()

}


const addToBeDelete = (el) => {

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
    //console.log($(deleteIds).val)
}

const addToValidArray = (file) => {
    if(!tmpForMultipleFiles.hasOwnProperty(file.name)){
        tmpForMultipleFiles[file.name] = file
        // выводим перью
        renderFilePreview(file)
        addFilesListToInput()
    }
}
const addFilesListToInput = () => {
    const dt = new DataTransfer();
    for (key in tmpForMultipleFiles)
        if(tmpForMultipleFiles[key] != 'old')
            dt.items.add(tmpForMultipleFiles[key]);
    document.querySelector('.js_fileInput').files = dt.files
}
// Убераем сообщения об ошибках
const removeNotice = (el = false) => {
    const inputInput = el || document.querySelector('.js_fileInput')
    if (inputInput.nextElementSibling)
        inputInput.nextElementSibling.classList.remove('show')
}
// Правили валидации
const validateRule =  {
    limit: (file, el) => {
        let msg = 'Максимальное количество файлов 5',
            editImg = editingImagesNames.length || 0

        if (editImg + Object.keys(tmpForMultipleFiles).length + 1 > 5) {
            showNotice(el, msg)
            return false
        }
        return true
    },
        size: (file, el) => {
        let msg = 'Максимальный размер 2 мб';
        if (file.size > 1024 * 1024 * 2) {
            showNotice(el, msg)
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
            showNotice(el, msg)
            return false
        }
        return true
    }
}
// Выводим сообщение об ошибках
const showNotice = function(el, msg) {
    let errorElement = el.nextElementSibling
    errorElement.classList.add("show")
    errorElement.innerHTML = msg
}
const renderFilePreview = function(file){
    let previewList = document.querySelector(".image-preview"),
        fakeUpload = document.querySelector(".fake-upload"),
        hash = md5(file.name),
        ext = file.name.split('.').pop(),
        previewItem = `
            <div class="js_newImgItem image-preview__item" onclick="setAsMain(this, '${hash}.${ext}')">
                <img src="${URL.createObjectURL(file)}" alt="">
                <span class="image-preview__name">${file.name}</span>
                <svg onclick="event.stopPropagation(); removeFromArray(this)" data-name="${file.name}" class="image-preview__del">
                    <use xlink:href="/images/icons.svg#icon-close"></use>
                </svg>
                <div class="image-preview__process">
                    <div class="image-preview__bar"></div>
                </div>
            </div>
            `;
    fakeUpload.insertAdjacentHTML('beforebegin', previewItem);
}


// Отмечаем файл как главный
const setAsMain = (el, name = null) => {
    if(el.classList.contains('js_newImgItem')) {
        if (el.parentElement) {
            const notMain = el.parentElement.querySelectorAll('.image-preview__item')
            if (notMain.length)
                notMain.forEach(item => {
                    item.classList.remove('image_main')
                })
        }
        el.classList.add('image_main')
        document.querySelector('input#main_image').value = name
    }
}


const postUp = (e) => {
    e.preventDefault()

    let postId = e.target.getAttribute('data-id'),
        postUpMsg = e.target.previousElementSibling

    //console.log(postId)
    if (postId) {
        axios.post(
            '/admin/article/update',
            {id: postId},
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }
        ).then(function (response) {
            postUpMsg.innerHTML = response.data
        })
    }
    //this.setAttribute('disabled', !this.getAttribute('disabled'))

}


