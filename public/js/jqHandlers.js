
$(document).ready(function () {
    // Карусель на превьюшках
    //$('.ad__desktop').brazzersCarousel();

    $('.js_ads__delete').on('click', async function(e){
        e.preventDefault()
        if (!confirm('Are you sure?')) return
        const url = this.dataset.url

        const res =  await requsetJs.default('delete', url);


    })
});