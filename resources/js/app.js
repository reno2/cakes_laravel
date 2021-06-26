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

import VueSocialSharing from 'vue-social-sharing'
Vue.use(VueSocialSharing);

require('./bootstrap');
window.moment = require('moment');
moment.locale('ru')
moment().format()




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


// import Swiper JS
// import Swiper from 'swiper';
//
// import SwiperCore, { Navigation } from 'swiper';
// SwiperCore.use([Navigation]);

// import 'toastr/build/toastr.css'
// window.toastr = require('toastr');

import 'iziToast/dist/css/iziToast.css'
window.iziToast = require('iziToast');


import Swiper from 'swiper/bundle';
import 'swiper/swiper-bundle.css';

const galleryThumbs = new Swiper('.ad-detail__navigation', {
    loop: true,
    slidesPerView: 5,
    spaceBetween: 20,
    observer: true,
    observeParents: true,
     freeMode: true,
    loopedSlides: 3, //looped slides should be the same
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
    navigation: {
        nextEl: '.arrow__right',
        prevEl: '.arrow__left',
    },
});

const swiper = new Swiper('.ad-detail__figure', {
    direction: 'horizontal',
    speed: 400,
    spaceBetween: 100,
    freeMode: false,
    loopedSlides: 5,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
    pagination: {
        el: '.swiper-pagination',
    },
    navigation: {
        nextEl: '.arrow__right',
        prevEl: '.arrow__left',
    },
    thumbs: {
        swiper: galleryThumbs,
    },
});

