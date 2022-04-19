/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');
window.md5 = require('md5');
window.Vue = require('vue');
import * as VeeValidate from 'vee-validate';


Vue.use(VeeValidate);

import VueSocialSharing from 'vue-social-sharing';

import IMask from 'imask';

window.IMask  = IMask;

Vue.use(VueSocialSharing);

require('./bootstrap');
window.moment = require('moment');
moment.locale('ru');
moment().format();




/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


//Vue.component('features-component', require('./components/FeaturesComponent.vue'));
//Vue.directive('sticky-scroll', require('./directives/Scroll').default);
//
// Vue.directive('scroll', {
//     inserted: function (el, binding) {
//         let f = function (evt) {
//             console.log('tetret');
//             if (binding.value(evt, el)) {
//                 window.removeEventListener('scroll', f)
//             }
//         }
//         window.addEventListener('scroll', f)
//     }
// })

require('./directives/scroll.js');

Vue.component('features-component', require('./components/FeaturesComponent.vue').default);
Vue.component('fileinput-component', require('./components/FileInputComponent.vue').default);
Vue.component('fileautocomplite-component', require('./components/FileautocompliteComponent.vue').default);
Vue.component('filemultiinput-component', require('./components/FileMultiInputComponent.vue').default);
Vue.component('addresssearchstreet-component', require('./components/AddressSearchStreetComponent.vue').default);
Vue.component('multifileupload-component', require('./components/MultiFileUploadComponent.vue').default);
Vue.component('addcomment', require('./components/AddComment.vue').default);
Vue.component('socialshare', require('./components/SocialShare.vue').default);
Vue.component('mobilemenu', require('./components/MobileMenu.vue').default);


const app = new Vue({
    el: '#app',
});



/**
 * Подключаем пакет для вывода уведомлений
 */
window.iziToast = require('izitoast');
import 'izitoast/dist/css/iziToast.min.css';


import Swiper from 'swiper/bundle';
import 'swiper/swiper-bundle.css';



const galleryThumbs = new Swiper('.article-detail__navigation', {
    spaceBetween: 10,
    slidesPerView: 'auto',
    freeMode: false,
    slideToClickedSlide: true,
    loopedSlides: 4,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
    navigation: {
        nextEl: '.js_swiperNavigate .arrow__left',
        prevEl: '.js_swiperNavigate .arrow__right',
    },

});
const galleryTop = new Swiper('.article-detail__figure', {
    spaceBetween: 10,
    freeMode: false,
    centeredSlides: true,
    navigation: {
        nextEl: '.arrow__left',
        prevEl: '.arrow__right',
    },
    thumbs: {
        swiper: galleryThumbs
    }
});


document.addEventListener("DOMContentLoaded",   (e) => {
    const swiperSlider = new Swiper('.js_collection', {
        spaceBetween: 10,
        slidesPerView: 'auto',
        navigation: {

        }
    });
})


