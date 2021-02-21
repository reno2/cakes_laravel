document.addEventListener("DOMContentLoaded", () => {
    //document.querySelectorAll('.js_validate').forEach(el=> {
        //el.addEventListener('keyup', validate)})
})
document.addEventListener("DOMContentLoaded", () => {
    const formCreate = document.querySelector('.js_adsCreate')
    formCreate.addEventListener('submit', formSubmit)
})

function formSubmit(e){

    let valid = true
    try {
        e.target.querySelectorAll('input.js_validate').forEach(el => {
            if(!validateInput(el)){
                throw new Error();
            }
        })
    }catch (error) {
        e.preventDefault();
        alert('Исправте ошибки')
    }

}
function validateInput(el) {
    removeError(el);
    if (el.classList.contains('js_numbersPoint')) {
        const pattern =  /^(\d)*(\.)?([0-9]{1,3})?$/g;
        if (!pattern.test(el.value)) {
            showError('.js_numbersPoint', el);
            return false
        }else return true
    }else
    return true
}

function validate() {

    if (!this.value) return
    removeError(this);
    //Check mask
    if (this.classList.contains('js_maskWeight')) {
        const x = this.value
            .replace(/^0/g, "")
            .replace(/\D/g, "")
            .match(/^(\d{0,1})(\d{0,1})(\d{0,1})(\d{0,1})(\d{0,1})(.*)?$/i);
        if (x[1] && !x[4]) {
            this.value = `0.${x[1]}${x[2]}${x[3]}`;
        } else if (x[1] && x[4] && !x[5]) {
            this.value = `${x[1]}.${x[2]}${x[3]}${x[4]}`;
        } else if (x[1] && x[5]) {
            this.value = `${x[1]}${x[2]}.${x[3]}${x[4]}${x[5]}`;
        }
    }

    if (this.classList.contains('js_numbersPoint')) {
        const pattern =  /^(\d)*(\.)?([0-9]{1,2})?$/g;
        if (!pattern.test(this.value)) {
            showError('.js_numbersPoint', this);
        }
    }
}

function showError(type, element) {
    let errorEl = element.parentElement.querySelector(`.js_error${type}`)
    errorEl.classList.add('show')
}

function removeError(element) {
    let errorEl = element.parentElement.querySelector(`.js_error`).classList.remove('show')
}
