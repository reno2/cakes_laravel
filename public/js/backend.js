window.onload = function () {

    // Сброс фильтров в админке
   let filterReset = document.getElementById('reset-filter')
   if(filterReset) filterReset.addEventListener('click', function (e) {
        e.preventDefault()
        let filters = document.getElementById('filters');
        let filtersInputs = filters.querySelectorAll('input[type=radio]')
        filtersInputs.forEach((e, i) => {
            e.checked = false
        })
    })
    // Конец сброса фильтров


    // Проверяем возможность изменения слага
    changeSlug()

};


function changeSlug() {
    const changeSlugCheckbox = document.querySelectorAll('.js_slug__change')
    if(changeSlugCheckbox.length){
        changeSlugCheckbox.forEach((el, inx) => {
            el.addEventListener('change', changeSlugState)
        })
    }

}
function changeSlugState(e){
    const input = e.target
    const slugInput = input.closest('form').querySelector(`.${input.getAttribute('data-slug-input')}`)
    const inputAttributes = ['disabled', 'readonly'];
    if(input.checked){
        inputAttributes.forEach( attribute => slugInput.removeAttribute(attribute))
    }else{
        inputAttributes.forEach( attribute => slugInput.setAttribute(attribute, attribute))
    }
}