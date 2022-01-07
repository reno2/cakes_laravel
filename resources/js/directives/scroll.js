Vue.directive('scroll', {
    inserted: function (el, binding) {
       // let rect = el.getBoundingClientRect();
       // let elPos = el.offsetTop

        let f = function (evt) {
            let rect = el.getBoundingClientRect();
            let elPos = el.offsetTop

           // console.log(pageYOffset ,   elPos, rect.height,  window.innerHeight, "==");
            if( pageYOffset < elPos) {
                el.classList.add('stk')
                // el.style.cssText = `
                //     position: absolute;
                //     bottom: ${pageYOffset + window.innerHeight + rect.height}px;
                // `
            }else{
                el.classList.remove('stk')
                // el.style.cssText = `
                //     position: static;
                //     bottom: 0;
                // `
            }
            // if (binding.value(evt, el)) {
            //     window.removeEventListener('scroll', f)
            // }
        }
        window.addEventListener('scroll', f)
    }
})