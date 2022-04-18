<div class="js_modal modal" id="show__phone">
    <div class="modal__body">
        <div class="js_modalContent modal__main modal__container modal__info">
            <div class="modal__small">
                Контакт: {{$article->user->profiles->first()->contact1}}
            </div>
            <svg class="js_modalClose modal__close svg_close">
                <use xlink:href="{{asset('images/icons.svg#icon-close')}}"></use>
            </svg>
            <div class="modal__text"></div>
        </div>
    </div>
</div>