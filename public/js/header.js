window.onload = function () {
    const profileItem = document.querySelectorAll('.js_profile__item')
    profileItem.forEach((el, inx) => {
        el.addEventListener('mouseenter', menuShow);
    })

    const openSearch = document.querySelector('.js_search__open')
    openSearch.addEventListener('click', searchEvent);
    const closeSearch = document.querySelector('.js_search__close')
    closeSearch.addEventListener('click', searchClose);
}

const menuShow = (e) => {
    const menu = e.target.closest('.js_profile__item').querySelector('.js_profile__menu')
    if(!menu) return

    menu.classList.add('show')
    e.target.addEventListener('mouseleave', menuHide)

}

const menuHide = (e) => {
    const menu = e.target.querySelector('.js_profile__menu')
    menu.classList.remove('show')
}

const searchEvent = (e) => {
    e.preventDefault()
    const searchLink = e.target.closest('.js_search__open')

    if(searchLink.classList.contains('isOpen')){
        const searchForm = document.querySelector('.js_search-form__desc')
        console.log( searchForm);
         searchForm.submit()
    }else {

        searchLink.classList.add('isOpen')
        e.target.closest('.header-middle__inner').querySelector('.search').classList.add('show')
    }
}

const searchClose = (e) => {
    console.log(this);
    e.target.closest('.js_search__block').classList.remove('show')
    e.target.closest('.header-middle__inner').querySelector('.js_search__open').classList.remove('isOpen')
}