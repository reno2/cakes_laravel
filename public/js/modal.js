
document.addEventListener("DOMContentLoaded", () => {
    // Обработка нажатия на кнопку открыть форму
    const formCreate = document.querySelectorAll('.js_modal')
    formCreate.forEach(formEl => formEl.addEventListener('click', modalOpen))



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

    // Закрытие модалки
    const modalCloseBtn = document.querySelectorAll('.js_modalClose')
    modalCloseBtn.forEach(closeBtn => closeBtn.addEventListener('click', modalClose))
})

function modalFormSubmit(event) {
    const showMainError = this.classList.contains('js_mainError')
    const submitBtn = this.querySelector('[type="submit"]')
    submitBtn.disabled = true
    event.preventDefault();
    axios.post(
        "profile/comments",
        new FormData(this),
        {
            headers: {
                'X-CSRF-TOKEN':
                    $('meta[name="csrf-token"]').attr('content')
            }
        }
    ).then(result => {
        if (result.status === 200) {
            this.reset()
            showMessage(result, this)
        }
    }).catch(error => {
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
    for (let err in errors.errors) {
        if (inputs[err]) {
            const element = inputs[err]
            if (element.type === 'textarea' || element.type === 'text') {
                element.classList.add('onError')
                element.parentElement.querySelector('.js_error')
                    .innerHTML = errors.errors[err]
            }
        }
    }
}

function showMessage(request, form) {
    if (request.status === 200) {
        const wrap = form?.closest('.js_modalWrap')
        wrap.querySelector('.js_modalContent').style.display = 'none';
        wrap.querySelector('.js_modalThanks').style.display = 'block';
        wrap.querySelector('.js_modalThanks').querySelector('.js_thanksText').innerHTML = request.data.msg
    }
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

function modalClose() {
    const modalWrap = document.querySelector('.js_modalWrap.open')
    console.log(modalWrap);
    modalWrap.querySelector('.js_modalContent').style.display = '';
    if(modalWrap.querySelector('.js_modalThanks'))
        modalWrap.querySelector('.js_modalThanks').style.display = 'none';

    modalWrap.classList.remove('open')
}
