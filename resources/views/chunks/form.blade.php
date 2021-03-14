<div id="feedback__question" class="modal__wrap">
    <div class="modal__container">
        <h4 class="modal__title">Задать вопрос</h4>
        <svg class="js_modalClose modal__close svg_close">
            <use xlink:href="{{asset('images/icons.svg#icon-close')}}"></use>
        </svg>
        <form class="js_questionForm modal__form question__form" action="">
            @csrf

            <input name="user_id" type="hidden" value="">
            <input name="article_id" type="hidden">
            <input name="from_user_id" type="hidden" value="{{(Auth::id()) ?? 0}}">
            <div class="modal__group">
                <input placeholder="Ваш email" class="modal__element" name="from_user_email" type="email" value="@if(Auth::user()) {{Auth::user()->email}} @else  @endif">
            </div>
            <div class="modal__group">
                <input placeholder="Ваше имя" class="modal__element" name="name" type="text" value="@if(Auth::user()) {{Auth::user()->profiles->first()->name}} @else гость @endif">
            </div>
            <div class="modal__group">
                <textarea placeholder="Ваше вопрос" class="modal__element" name="question" id="" cols="30" rows="10"></textarea>
            </div>
            <button class="btn btn-primary" type="submit">Задать вопрос</button>
        </form>
    </div>

</div>

