document.addEventListener('DOMContentLoaded', () => {
    const formCreate = document.querySelectorAll('.js_favorites');
    formCreate.forEach(formEl => formEl.addEventListener('submit', favorites));



    //b-toggle
    // $(document).click(function (e) {
    //     if (!$(e.target).is('.js_bToolContent') && !$(e.target).is('.js_bToggle') && !$(e.target).is('.js_bToggle use')) {
    //         const $allTooltips = $('.js_bToggle.open').each((inx, elem) => {
    //             $(elem).removeClass('open');
    //             $(elem).closest('.t-tooltip').find('.b-toggle__content').removeClass('open');
    //         });
    //     }
    // });
    //
    // $(document).on('click', '.js_bToggle, .js_bToggle use',
    //     function () {
    //         bToggle(this);
    //     }
    // );
    const toggle = document.querySelectorAll('.js_bToggle')
    toggle.forEach((el, inx)=>{
        el.addEventListener('click', function (e) {
            //e.stopPropagation()
            bToggle(el)
        })
    })


    // window.addEventListener('click', function (e) {
    //     if(e.target.classList.contains('js_bToggle')){
    //         console.log(this);
    //     }
    // })

});

window.addEventListener('click', function (e) {
    const targetClasses = e.target.classList
    if(!targetClasses.contains('js_bToolContent') ){
        document.querySelectorAll('.js_bToggle.open').forEach((el, inx)=>{
            if(el !== e.target) {
                el.parentElement.querySelector('.b-toggle__content').classList.remove('open')
                el.classList.remove('open')
            }
        })
    }
})

function bToggle(element) {
    console.log(element);
    if (!$(element).hasClass('open')) {
        const content = $(element).siblings(`.${$(element).data('toggle')}`);
        content.css({'left': (content.width() * -1) + 16 + 'px'}).addClass('open');
        $(element).addClass('open');
    }
}


function favorites(e) {
    let url = '/favorites';
    const id = e.target.querySelector('input[name="id"]').value;
    const token = e.target.querySelector('input[name="_token"]').value;

    axios.post(
        url,
        {id: id},
        {
            headers: {
                'X-CSRF-TOKEN': token
            }
        }
    ).then(function (response) {
        if (response.status === 200) {
            const favoritesIcon = e.target.querySelector('.js_favoritesIcon');
            document.querySelector('.js_favorites').innerHTML = response.data.count;
            if (response.data.action === 'del') {
                favoritesIcon.classList.remove('fas');
                favoritesIcon.classList.add('far');
            } else {
                favoritesIcon.classList.remove('far');
                favoritesIcon.classList.add('fas');
            }
        }
    });
    e.preventDefault();
}




