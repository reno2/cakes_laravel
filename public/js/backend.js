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


    //$( "#image-list" ).sortable();
};
