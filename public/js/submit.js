

document.querySelectorAll('.js_submit').forEach(el => {
    el.addEventListener('submit', submitForm)
})

const requestHandler = window.requsetJs;

function submitForm(e) {
    e.preventDefault()
    //togglePreloader(true)

}