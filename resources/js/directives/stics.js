import Vue from 'vue';

export default {
    stics,
};

const stics = {
    inserted: function (el, binding) {

        let f = function (evt) {
            console.log('test')
            if (binding.value(evt, el)) {
                window.removeEventListener('scroll', f)
            }
        }
        window.addEventListener('scroll', f)
    }
};

Vue.directive('stics', stics)