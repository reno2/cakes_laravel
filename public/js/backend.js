window.onload = function () {

    // Сброс фильтров в админке
    document.getElementById('reset-filter').addEventListener('click', function (e) {
        e.preventDefault()
        let filters = document.getElementById('filters');
        let filtersInputs = filters.querySelectorAll('input[type=radio]')
        filtersInputs.forEach((e, i) => {
            e.checked = false
        })
    })
    // Конец сброса фильтров
};
