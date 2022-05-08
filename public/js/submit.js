

document.querySelectorAll('.js_loading').forEach(el => {
    el.addEventListener('submit', submitForm)
})

const requestHandler = window.requsetJs;

function submitForm(e) {
    togglePreloader(true)
}