document.addEventListener('DOMContentLoaded', () => {
    const formCreate = document.querySelectorAll('.js_favorites');
    formCreate.forEach(formEl => formEl.addEventListener('submit', favorites));

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
       // console.log(e.target);
        document.querySelectorAll('.js_bToggle.open').forEach((el, inx) => {
            if (el !== e.target) {

                el.parentElement.querySelector('.b-toggle__content').classList.remove('open');
                el.classList.remove('open');
            }
        });
    }
});


//===================================================
document.addEventListener("noticeRead", event => {
    const userId = event.detail.userId
     updateUserNotice(userId)
});

function updateUserNotice(userId){
    axios.get('/profile/notifications/personal/'+userId)
        .then((res)=>{
            if(res.data.success){
                const notificationsElement = document.querySelector('.js_notificationsCount')
                if(notificationsElement){
                    notificationsElement.innerHTML = res.data.notifications
                }
            }
        })
        .catch(error=>{
            console.log(error);
        })
}

//===================================================

// Контекстное меню в списке постов
window.addEventListener('click', function (e) {
    //console.log(e);
    if (e.target.classList.contains('js_bToggle')) {
        return bToggle(e.target);
    }
    if ( e.target.closest('.js_bToggle') ) {
       return bToggle(e.target.closest('.js_bToggle'));
    }
}, true)

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
        const actionBlock = element.parentElement.querySelector('.js_bToolContent');
        element.classList.add('open')
        actionBlock.classList.add('open')
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
            const mainFavoritesCount = document.querySelector('.js_favoritesMain')
                if(mainFavoritesCount) mainFavoritesCount.innerHTML = response.data.count;
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




