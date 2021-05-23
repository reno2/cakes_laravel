document.addEventListener('DOMContentLoaded', () => {
    const formCreate = document.querySelectorAll('.js_favorites');
    formCreate.forEach(formEl => formEl.addEventListener('submit', favorites));

    const toggle = document.querySelectorAll('.js_bToggle');
    toggle.forEach((el, inx) => {
        el.addEventListener('click', function (e) {
            //e.stopPropagation()
            bToggle(el);
        });
    });

    // Обработчики на переключение табов объявлениях профиля
    const adsSwitcher = document.querySelectorAll('.js_adsSwitcher');

    if (adsSwitcher) {
        adsSwitcher.forEach(btn => {
            btn.addEventListener('click', (e) => profileAdsList(btn, e));
        });
    }
});

window.addEventListener('click', function (e) {
    const targetClasses = e.target.classList;
    if (!targetClasses.contains('js_bToolContent')) {
        document.querySelectorAll('.js_bToggle.open').forEach((el, inx) => {
            if (el !== e.target) {
                el.parentElement.querySelector('.b-toggle__content').classList.remove('open');
                el.classList.remove('open');
            }
        });
    }
});


function profileAdsList(element, e) {
    const target = element.getAttribute('data-status');
    const mainProfileBlock = element.closest?.('.profile-adverts');

    element.closest?.('.profile-adverts__switch').querySelectorAll('.js_adsSwitcher')
        .forEach(btn => btn.classList.remove('active'));
    element.classList.add('active')
    mainProfileBlock.querySelectorAll('.js_adsStatusGroups')?.forEach(block => {
        if (block.id === target) {
            block.classList.add('active');
        } else {
            block.classList.remove('active');
        }
    });
}

function bToggle(element) {

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




