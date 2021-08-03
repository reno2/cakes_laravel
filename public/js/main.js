window.onload = function () {
    //========================Проверяем что в урле есть якорь
    //========================И переключаем таб
    tabSwitcher()
}

function tabSwitcher() {
    if (location.href.includes('#moderate')) {
        //  console.log(document.querySelector("[href='#not_published']"));
        //document.querySelector("[href='#not_published']")?.click()
        document.querySelector('.js_onModerate')?.dispatchEvent(new MouseEvent('click'));
    }
}


document.addEventListener('DOMContentLoaded', () => {
    const formCreate = document.querySelectorAll('.js_favorites');
    formCreate.forEach(formEl => formEl.addEventListener('submit', favorites));
    //===================Обработчики на переключение=========================
    //====================табов объявлениях профиля==========================
    //=======================================================================
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
document.addEventListener('noticeRead', event => {
    const userId = event.detail.userId;
    updateUserNotice(userId);
});

function updateUserNotice(userId) {
    axios.get('/profile/notifications/personal/' + userId)
        .then((res) => {
            if (res.data.success) {
                const notificationsElement = document.querySelector('.js_notificationsCount');
                if (notificationsElement) {
                    notificationsElement.innerHTML = res.data.notifications;
                }
            }
        })
        .catch(error => {
            console.log(error);
        });
}

//===================================================

// Контекстное меню в списке постов
window.addEventListener('click', function (e) {
    //console.log(e);
    if (e.target.classList.contains('js_bToggle')) {
        return bToggle(e.target);
    }
    if (e.target.closest('.js_bToggle')) {
        return bToggle(e.target.closest('.js_bToggle'));
    }
}, true);

function profileAdsList(element, e) {
    e.preventDefault();
    const target = element.getAttribute('data-status');
    const mainProfileBlock = element.closest?.('.profile-adverts');

    element.closest?.('.profile-adverts__switch').querySelectorAll('.js_adsSwitcher')
        .forEach(btn => btn.classList.remove('active'));
    element.classList.add('active');
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
        element.classList.add('open');
        actionBlock.classList.add('open');
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
            const mainFavoritesCount = document.querySelector('.js_favoritesMain');
            if (mainFavoritesCount) mainFavoritesCount.innerHTML = response.data.count;
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


// =============================MENUS===================================
const menusToggles = document.querySelectorAll('.js_menuToggle');


if (menusToggles.length) {
    menusToggles.forEach((el, inx) => {
        el.addEventListener('click', toggleDMenu.bind(null, el));
    });
}

function toggleDMenu(el) {
    const actionBlock = el.parentElement.querySelector('.js_menuContent');
    const menuWrap = el.closest('.js_menuWrap');
    menuWrap?.classList.contains('menu_isOpen') ? menuWrap.classList.remove('menu_isOpen') : menuWrap.classList.add('menu_isOpen');
    //actionBlock.classList.contains('menu_isOpen') ? actionBlock.classList.remove('menu_isOpen') : actionBlock.classList.add('menu_isOpen')
}




const form = document.querySelector('#confirm_delete');
const btn = document.querySelector('.js_deleteSubmit');
btn?.addEventListener('click', function () {
    const url = form.querySelector('.url')?.value;
    const token = form.querySelector('[name="_token"]').value;
    axios.post(url, {
        _method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Token ' + token
        }
    }).then(result => {
        //showMessage(result, form)
        modalClose();

        const toDelId = form.getAttribute('data-id');
        document.querySelector(`.js_adsWrap[data-id="${toDelId}"]`).remove();
        iziToast.success({
            position: 'topRight',
            title: 'Уведомление',
            message: result.data.msg
        });

    }).catch(e => {
        iziToast.warning({
            position: 'topRight',
            title: 'Уведомление',
            message: e.message
        });
        console.log(e.message);
    });

});


