document.addEventListener("DOMContentLoaded", () => {
    // Обработка нажатия на кнопку открыть форму
    const formCreate = document.querySelectorAll('.js_modal')
    formCreate.forEach(formEl => formEl.addEventListener('click', modalForm))


    // Отправки формы задать вопрос
    const submitQuestionModal = document.querySelectorAll('.js_questionForm')
    submitQuestionModal[0].addEventListener('submit', modalFormSubmit)

    // Закрытие модалки
    const modalCloseBtn = document.querySelectorAll('.js_modalClose')
    modalCloseBtn.forEach(closeBtn => closeBtn.addEventListener('click', modalClose))
})

function modalFormSubmit(event) {
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
        if(result.status === 200)
            this.reset()

        showMessage(result, this)
        //modalClose()
    })
}
function showMessage(request, form) {
    console.log(request)
    if(request.status === 200){
        const wrap = form.parentElement.parentElement
        wrap.querySelector('.modal__main').style.display = 'none';
        wrap.querySelector('.modal__thanks').style.display = 'block';
        wrap.querySelector('.modal__thanks').querySelector('.modal__text').innerHTML = request.data.msg
    }
}

function modalForm(event = null) {
    event.preventDefault();
    const modalTarget = this.getAttribute('data-modal')
    const userId = this.getAttribute('data-user-id')
    const userName = this.getAttribute('data-user-name')
    const adsId = this.getAttribute('data-ads-id')
    const modal = document.querySelector(`#${modalTarget}`)

    modal.querySelector('input[name="user_id"]').value = userId
    modal.querySelector('input[name="article_id"]').value = adsId
    modal.classList.add('open')


}


function modalClose() {
    const modalWrap = document.querySelector('.modal__wrap')
    modalWrap.querySelector('.modal__main').style.display = '';
    modalWrap.querySelector('.modal__thanks').style.display = '';
    modalWrap.classList.remove('open')
}
