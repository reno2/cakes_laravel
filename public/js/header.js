window.onload = function () {
    const profileItem = document.querySelectorAll('.js_profile__item')
    profileItem.forEach((el, inx) => {
        el.addEventListener('mouseenter', menuShow);
    })
}

const menuShow = (e) => {
    const menu = e.target.querySelector('.js_profile__menu')
    menu.classList.add('show')
    e.target.addEventListener('mouseleave', menuHide)
}

const menuHide = (e) => {
    const menu = e.target.querySelector('.js_profile__menu')
    menu.classList.remove('show')
}