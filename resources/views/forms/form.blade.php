<div class="js_modalWrap modal__wrap" id="feedback__question">
    <div class="js_modalThanks modal__container modal__thanks">
        <h4 class="modal__title">Успех!</h4>
        <svg class="js_modalClose modal__close svg_close">
            <use xlink:href="{{asset('images/icons.svg#icon-close')}}"></use>
        </svg>
        <div class="js_thanksText modal__text"></div>
    </div>
    <div class="js_modalContent modal__container modal__main">
        <h4 class="modal__title">Задать вопрос</h4>
        <div role="alert" class="js_formError alert alert-danger form-error">
            <div class="js_errorMsg form-error__msg"></div>
            <svg class="js_closeError form-error__close svg_close">
                <use xlink:href="{{asset('images/icons.svg#icon-close')}}"></use>
            </svg>
        </div>
        <svg class="js_modalClose modal__close svg_close">
            <use xlink:href="{{asset('images/icons.svg#icon-close')}}"></use>
        </svg>
        <form class="js_questionForm modal__form question__form" action="">
            @csrf
            <input name="user_id" type="hidden" value="">
            <input name="article_id" type="hidden">
            <input name="user_fire" type="hidden" value="">
            <input name="from_user_id" type="hidden" value="{{(Auth::id()) ?? 0}}">
            <div class="modal__group">
                <input class="modal__element"
                       placeholder="Ваше имя"
                       name="name"
                       type="text"
                       value="@if(Auth::id()) {{Auth::user()->profiles->first()->name}} @endif">
                <span class="help-block text-danger js_error"></span>
            </div>


            <div class="modal__group">
                <textarea class="modal__element" placeholder="Ваше вопрос" name="question" id="" cols="30" rows="10"></textarea>
                <span class="help-block text-danger js_error"></span>
            </div>
            <button class="btn btn-primary" type="submit">Задать вопрос</button>

            <div class="captcha">
                <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                <div class="captcha__info">Сайт защищён reCAPTCHA Google</div> |
                <a class="captcha__link" href="https://policies.google.com/privacy">Privacy Policy</a> |
                <a class="captcha__link" href="https://policies.google.com/terms">Terms of Service</a>
            </div>


        </form>
    </div>

</div>

