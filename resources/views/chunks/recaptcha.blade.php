<script src="https://www.google.com/recaptcha/api.js?render={{config('services.google_recaptcha.recaptcha_key')}}"></script>
<script>
    grecaptcha.ready(function () {
        grecaptcha.execute("{{config('services.google_recaptcha.recaptcha_key')}}", { action: 'contact' }).then(function (token) {
            const recaptchaResponse = document.querySelectorAll('#recaptchaResponse');
            if(recaptchaResponse) {
                recaptchaResponse.forEach((el, inx) => {
                    el.value = token;
                })
            }
        });
    });

</script>