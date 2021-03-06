
document.addEventListener("DOMContentLoaded", () => {
    const formCreate = document.querySelectorAll('.js_favorites')
    formCreate.forEach(formEl => formEl.addEventListener('submit', favorites))
})
function favorites(e){
    let url = '/favorites'

    const id =e.target.querySelector('input[name="id"]').value
    const token =e.target.querySelector('input[name="_token"]').value

    axios.post(
        url,
        {id: id},
        {
            headers: {
                'X-CSRF-TOKEN': token
            }
        }
    ).then(function (response) {
        if(response.status === 200){
            const favoritesIcon = e.target.querySelector('.js_favoritesIcon')
            if(response.data === 'del'){
                favoritesIcon.classList.remove('fas')
                favoritesIcon.classList.add('far')
            }else{
                favoritesIcon.classList.remove('far')
                favoritesIcon.classList.add('fas')
            }
        }
    })
    e.preventDefault();
}
