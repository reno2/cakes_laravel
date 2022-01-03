
document.addEventListener("DOMContentLoaded", () => {


    // Обработка нажатия на кнопку открыть форму
    const formCreate = document.querySelectorAll('.js_modal__open')
    formCreate.forEach(formEl => formEl.addEventListener('click', modalOpen))


    // Закрытие модалки
    const modalCloseBtn = document.querySelectorAll('.js_modalClose')
    if(modalCloseBtn.length > 0){
        modalCloseBtn.forEach((el, inx) => {
           el.addEventListener('click', function(e){
               popupClose(e.target.closest('.js_modal'))
           })
        })
    }





    const questionForm = document.querySelector('.js_questionForm')
    if (questionForm) {
        Object.values(questionForm.elements).forEach(formElement => {
            if (formElement.type === 'textarea' || formElement.type === 'input')
                formElement.addEventListener('input', () => {
                    formElement.classList.remove('onError')
                    formElement.parentElement.querySelector('.js_error')
                        .innerHTML = ''
                })
        })
    }

    // Обработка скрытия общего сообщения об ошибках формы при клике на закрытие блока с сообщением
    const closeFormError = document.querySelector('.js_closeError')
    if (closeFormError) closeFormError.addEventListener('click', () => {
        closeFormError.parentElement.classList.remove('show')
        closeFormError.parentElement.querySelector('.js_errorMsg').innerHTML = ''
    })

    // Отправки формы задать вопрос
    const submitQuestionModal = document.querySelectorAll('.js_questionForm')
    if (submitQuestionModal.length)
        submitQuestionModal[0].addEventListener('submit', modalFormSubmit)


})

function modalFormSubmit(event) {
    const showMainError = this.classList.contains('js_mainError')
    const submitBtn = this.querySelector('[type="submit"]')
    submitBtn.disabled = true
    event.preventDefault();

    axios.post(
        "/profile/comments",
        new FormData(this),
        {
            headers: {
                'X-CSRF-TOKEN':
                    $('meta[name="csrf-token"]').attr('content')
            }
        }
    ).then(result => {

        if (result.status === 200) {
            resetInputs(this)
            this.reset()
            const modal = this.closest('.js_modal')
            const success = modal.querySelector('.js_modal__success')
            //Если блок с успехом есть, то выводим
           if(success) showSuccess(result, modal, success)
           else popupClose(modal)
        }
    }).catch(error => {
        console.log(error);
        errorHandler(error.response.data, this, showMainError)
    }).then(() => {
        submitBtn.disabled = false
    })

}

function errorHandler(errors, form, showMainError = false) {
    const inputs = form.elements

    if (errors.message && showMainError) {
        const formInfo = form.parentElement.querySelector('.js_formError')
        formInfo.classList.add('show')
        formInfo.querySelector('.js_errorMsg').innerHTML = errors.message
    }
    console.log(inputs, errors.errors);
    for (let err in errors.errors) {
        if (inputs[err]) {
            const element = inputs[err]
            if (element.type === 'textarea' || element.type === 'text' ||  element.type === 'hidden') {
                element.closest('.js_form-cell').classList.add('onError')
                element.closest('.js_form-cell').querySelector('.js_error')
                    .innerHTML = errors.errors[err]
            }
        }
    }
}

function showSuccess(request, modal, successBlock) {

    modal.classList.add('modal_response')
 //  const modal = form?.closest('.js_modalWrap')
 //  modal.classList.add('modal_response', 'modal_thanks')
      // wrap.querySelector('.js_modalContent').style.display = 'none';
      //  wrap.querySelector('.js_modalThanks').style.display = 'block';
      //  wrap.querySelector('.js_modalThanks').querySelector('.js_thanksText').innerHTML = request.data.msg

}

function modalOpen(event = null) {
    event.preventDefault();
    const modalTarget = this.getAttribute('data-modal')
    const modal = document.querySelector(`#${modalTarget}`)

    if(this.getAttribute('data-id'))
        modal.setAttribute('data-id', this.getAttribute('data-id'))

    if(this.getAttribute('data-url')){
        modal.querySelector('input[name="url"]').value = this.getAttribute('data-url')
    }
    if(this.getAttribute('data-method')){
        modal.querySelector('input[name="method"]').value = this.getAttribute('data-method')
    }
    modal.classList.add('open')
    modal.addEventListener('click', function(e){
        if(!e.target.closest('.js_modalContent')){
            popupClose(modal)
        }
    })
    const userId = this.getAttribute('data-user-id')
    const userName = this.getAttribute('data-user-name')
    const adsId = this.getAttribute('data-ads-id')
    let user_id
    let article_id
    if (user_id = modal.querySelector('input[name="user_id"]'))
        user_id.value = userId

    if (article_id = modal.querySelector('input[name="article_id"]'))
        article_id.value = adsId
}

// Закрываем модалку
function popupClose(popup){
    //popup.querySelector('.js_modalContent').style.display = '';
    //if(popup.querySelector('.js_modalThanks'))
    //    popup.querySelector('.js_modalThanks').style.display = 'none';
    popup.classList.remove('open', 'modal_response')
}


