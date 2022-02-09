/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');
// import 'jquery-ui/ui/widgets/sortable'
// import 'jquery-ui/themes/base/all.css'
window.md5 = require('md5');
window.Vue = require('vue');
import * as VeeValidate from 'vee-validate';


Vue.use(VeeValidate);

import VueSocialSharing from 'vue-social-sharing';


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

require("./directives/scroll.js");

Vue.component('features-component', require('./components/FeaturesComponent.vue').default);
Vue.component('fileinput-component', require('./components/FileInputComponent.vue').default);
Vue.component('fileautocomplite-component', require('./components/FileautocompliteComponent.vue').default);
Vue.component('filemultiinput-component', require('./components/FileMultiInputComponent.vue').default);
Vue.component('addresssearchstreet-component', require('./components/AddressSearchStreetComponent.vue').default);
Vue.component('multifileupload-component', require('./components/MultiFileUploadComponent.vue').default);
Vue.component('addcomment', require('./components/AddComment.vue').default);
Vue.component('socialshare', require('./components/SocialShare.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

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


// const slideItems = document.querySelectorAll('.ad-detail__small');
// const thumbSlider = document.querySelector('.ad-detail__navigation');
// console.log(thumbSlider);
// const thumbArrows = thumbSlider.querySelector('.js_swiperNavigate');
//
// thumbArrows.style.display = 'none'


// const options = {
//     loop: true,
//     slidesPerView: 4,
//     spaceBetween: 30,
//     // observer: true,
//     // observeParents: true,
//     freeMode: false,
//     height: 100,
//     //  loopedSlides: 3, //looped slides should be the same
//     // watchSlidesVisibility: true,
//     // watchSlidesProgress: true,
//     navigation: {
//         nextEl: '.arrow__right',
//         prevEl: '.arrow__left',
//     },
// }
// const galleryThumbs = new Swiper('.ad-detail__navigation', options);
//
// const galleryTop = new Swiper('.ad-detail__figure', {
//     freeMode: false,
//     loop: true,
//     loopedSlides: 4,
//     // watchSlidesVisibility: true,
//     // watchSlidesProgress: true,
//     pagination: {
//         el: '.swiper-pagination',
//     },
//     navigation: {
//         nextEl: '.arrow__right',
//         prevEl: '.arrow__left',
//     },
//     // thumbs: {
//     //     swiper: galleryThumbs,
//     // },
// });

const galleryThumbs = new Swiper('.ad-detail__navigation', {
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
const galleryTop = new Swiper('.ad-detail__figure', {
    spaceBetween: 10,
    freeMode: false,
    centeredSlides: true,
    navigation: {
        nextEl: '.arrow__left',
        prevEl: '.arrow__right',
    },
    thumbs: {
        swiper: galleryThumbs
    },


});
// galleryTop.controller.control = galleryThumbs;
// galleryThumbs.controller.control = galleryTop;

// galleryThumbs.init();



//
// galleryThumbs.on('init', function(swiper){
//     if(swiper.activeIndex < 4){
//         swiper.prependSlide([
//             '<div class="swiper-slide swiper__fake"></div>',
//             '<div class="swiper-slide swiper__fake"></div>',
//         ]);
//
//         galleryThumbs.params.loop = false
//         swiper.allowSlideNext = false
//         swiper.allowSlidePrev = false
//         swiper.allowTouchMove = false
//         document.querySelector('.swiper-container').classList.add('swiper-no-swiping')
//         swiper.update()
//     }
// })

// galleryThumbs.on('resize', function(swiper){
//     console.log(this);
// })
// if(slideItems.length > 4)
// galleryThumbs.init();


