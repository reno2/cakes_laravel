<script src="https://www.google.com/recaptcha/api.js?render={{config('services.google_recaptcha.recaptcha_key')}}"></script>
<script>
    window.googleCaptchaKey = "{{config('services.google_recaptcha.recaptcha_key')}}";

    function grecaptcha_execute(){
        grecaptcha.execute(window.googleCaptchaKey, {action: 'contact'}).then(function(token) {
            const recaptchaResponse = document.querySelectorAll('#recaptchaResponse');
                    if(recaptchaResponse) {
                        recaptchaResponse.forEach((el, inx) => {
                            el.value = token;
                        })
                    }
        });
    }

</script>



