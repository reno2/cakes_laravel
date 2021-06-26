<div class="js_modalWrap modal__wrap ads-del" id="confirm_delete" data-id>
    <div class="js_modalThanks modal__container modal__thanks ads-del__thanks">
        <h4 class="modal__small">Успех!</h4>
        <svg class="js_modalClose modal__close svg_close">
            <use xlink:href="{{asset('images/icons.svg#icon-close')}}"></use>
        </svg>
        <div class="js_thanksText modal__text"></div>
    </div>
    <div class="js_modalContent modal__container modal__info ads-del__main">
        <h4 class="modal__small">Хотите удалить?</h4>
        <svg class="js_modalClose modal__close svg_close">
            <use xlink:href="{{asset('images/icons.svg#icon-close')}}"></use>
        </svg>
        @csrf
        <input class="url" name="url" type="hidden">
        <div class="modal__group">
            <button class="js_deleteSubmit btn btn-primary" type="submit">Удалить</button>
            <button class="js_modalClose btn btn-default marginLeftOne">Отмена</button>
        </div>

    </div>
</div>