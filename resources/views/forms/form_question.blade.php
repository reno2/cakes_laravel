<div class="js_modal modal" id="feedback__question">
    <div class="modal__body">
        <div class="js_modal__success modal__success modal__container modal_small">
            <h4 class="modal__title">Успех!</h4>
            <svg class="js_modalClose modal__close svg_close">
                <use xlink:href="{{asset('images/icons.svg#icon-close')}}"></use>
            </svg>
            <div class="js_thanksText modal__text"></div>
        </div>
        <div class="js_modalContent modal__main modal__container modal_small">
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
                <input name="name" type="hidden" value="@if(Auth::id()) {{Auth::user()->profiles->first()->name}} @endif">




                <div class="modal__group form-cell js_form-cell">
                    <textarea class="modal__element form-cell__textarea" name="question" id="" cols="30" rows="6"></textarea>
                    <label class="form-cell__placeholder">Ваш вопрос*</label>
                    <svg class="form-cell__cleaner js_input__clean">
                        <use xlink:href="{{asset('images/icons.svg#icon-close')}}"></use>
                    </svg>
                    <span class="help-block text-danger js_error"></span>
                </div>
                <button class="btn blue wide" type="submit">Задать вопрос</button>
                <div class="modal__group form-cell js_form-cell">
                    <div class="captcha">
                        <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                        <div class="captcha__info">reCAPTCHA Google</div>
                        |
                        <a class="captcha__link" href="https://policies.google.com/privacy">Конфиденциальность</a>
                        |
                        <a class="captcha__link" href="https://policies.google.com/terms">Условия</a>
                    </div>
                    <span class="help-block text-danger js_error"></span>
                </div>

            </form>
        </div>
    </div>
</div>

