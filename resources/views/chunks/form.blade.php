<div id="feedback__question" class="modal__wrap">
    <div class="modal__container">
        <h4 class="modal__title">Задать вопрос</h4>
        <svg class="js_modalClose modal__close svg_close">
            <use xlink:href="{{asset('images/icons.svg#icon-close')}}"></use>
        </svg>
        <form class="modal__form question__form" action="">
            @csrf
            <input name="to-user" type="hidden" value>
            <input name="from-user" type="hidden">
            <input name="ads-id" type="hidden">
            <div class="modal__group">
                <input placeholder="Ваше имя" class="modal__element" name="name" type="text">
            </div>
            <div class="modal__group">
                <textarea placeholder="Ваше вопрос" class="modal__element" name="question" id="" cols="30" rows="10"></textarea>
            </div>
        </form>
    </div>

</div>

