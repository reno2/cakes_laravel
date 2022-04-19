document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('.js_form-cell > input, .js_form-cell > textarea');
    inputs.forEach((el, inx) => {
        setEvents(el);
    });
    const clearSvg = document.querySelectorAll('.js_form-cell > .js_input__clean');
    if (clearSvg) {
        clearSvg.forEach((el, inx) => {
            clearInputs(el);
        });
    }
    phoneMask();
});

const setEvents = (el) => {
    el.addEventListener('focus', (e) => {
        e.target.closest('.js_form-cell').classList.add('onFocus');
    });
    el.addEventListener('blur', (e) => {
        e.target.closest('.js_form-cell').classList.remove('onFocus');
    });
    el.addEventListener('input', (e) => {
        const value = e.target.value;
        if (!value) {
            e.target.closest('.js_form-cell').classList.remove('filled');
        } else {
            e.target.closest('.js_form-cell').classList.add('filled');
        }

    });
};

const clearInputs = (el) => {
    el.addEventListener('click', (e) => {
        const formCell = e.target.closest('.js_form-cell');
        console.log(formCell);
        const inputs = formCell.querySelectorAll('input, textarea');
        inputs.forEach((el, inx) => {
            el.value = '';
        });
        formCell.classList.remove('filled', 'onError');
    });
};

const resetInputs = (form) => {
    const inputs = form.querySelectorAll('.js_form-cell > input, .js_form-cell > textarea');
    if (inputs) {
        inputs.forEach((el, inx) => {
            const clearSvg = el.closest('.js_form-cell').querySelector('.js_input__clean');
            clearSvg.dispatchEvent(new Event('click'));
        });
    }
};

const phoneMask = () => {
    const inputs = document.querySelectorAll('.js_phone_mask');
    if (inputs) {
        inputs.forEach(el => {
            IMask(el, {
                mask: '+{7}(000) 000-00-00',
                placeholderChar: '#'
            });
        });
    }
};
