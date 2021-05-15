<div class="modal__wrap" id="confirm_delete">
    <div class="modal__container modal__thanks">
        <h4 class="modal__small">Материал удалён</h4>
        <svg class="js_modalClose modal__close svg_close">
            <use xlink:href="{{asset('images/icons.svg#icon-close')}}"></use>
        </svg>
        <div class="modal__text"></div>
    </div>
    <div class="modal__container modal__info">
        <h4 class="modal__small">Хотите удалить?</h4>
        <svg class="js_modalClose modal__close svg_close">
            <use xlink:href="{{asset('images/icons.svg#icon-close')}}"></use>
        </svg>
        @csrf
        <input class="url" name="url" type="hidden">
        <div class="modal__group">
            <button class="js_submit btn btn-primary" type="submit">Удалить</button>
            <button class="js_modalClose btn btn-default marginLeftOne">Отмена</button>
        </div>

    </div>
</div>
<script>

    const form = document.querySelector('#confirm_delete');
    const btn = document.querySelector('.js_submit');
    btn.addEventListener('click', function () {
        const url = form.querySelector('.url')?.value;
        const token = form.querySelector('[name="_token"]').value;

        axios.post(url, {
           _method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Token ' + token
            }
        }).then(result => {
            console.log(result);
            showMessage(result, form)
        }).catch(e => {
            console.log(e.message);
        });

    });

</script>