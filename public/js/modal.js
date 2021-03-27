document.addEventListener("DOMContentLoaded", () => {
    // Обработка нажатия на кнопку открыть форму
    const formCreate = document.querySelectorAll('.js_modal')
    formCreate.forEach(formEl => formEl.addEventListener('click', modalForm))

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
    // console.log(request)
    if (request.status === 200) {
        const wrap = form.parentElement.parentElement
        wrap.querySelector('.modal__main').style.display = 'none';
        wrap.querySelector('.modal__thanks').style.display = 'block';
        wrap.querySelector('.modal__thanks').querySelector('.modal__text').innerHTML = request.data.msg
    }
}

function modalForm(event = null) {
    event.preventDefault();
    const modalTarget = this.getAttribute('data-modal')

    const modal = document.querySelector(`#${modalTarget}`)

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
    const modalWrap = document.querySelector('.modal__wrap')
    modalWrap.querySelector('.modal__container').style.display = '';
    modalWrap.classList.remove('open')
}
