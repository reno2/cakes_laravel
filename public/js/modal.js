
document.addEventListener("DOMContentLoaded", () => {
    // Обработка нажатия на кнопку открыть форму
    const formCreate = document.querySelectorAll('.js_modal')
    formCreate.forEach(formEl => formEl.addEventListener('click', modalForm))

    // Закрытие модалки
    const modalCloseBtn = document.querySelectorAll('.js_modalClose')
    modalCloseBtn.forEach(closeBtn => closeBtn.addEventListener('click', modalClose))
})


function modalForm(event){
    event.preventDefault();
    const modalTarget = this.getAttribute('data-modal')
    const userId = this.getAttribute('data-user-id')
    const userName = this.getAttribute('data-user-name')
    const modal = document.querySelector(`#${modalTarget}`)
    modal.querySelector('input[name="to-user"]').value = userId
    modal.classList.add('open')
    //modal.style.display = 'block'
    axios.post(
        'send/msg',
        {userId: userId},
        {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }
    ).then(result => {

    })

}


function modalClose(event){
    console.log(this)
    const modalWrap = document.querySelector('.modal__wrap')
    modalWrap.classList.remove('open')
}
