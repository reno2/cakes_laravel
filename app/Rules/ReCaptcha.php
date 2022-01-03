<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;


class ReCaptcha implements Rule
{

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Создаем POST запрос
        $recaptcha_url = config('services.google_recaptcha.recaptcha_url');
        $recaptcha_secret = config('services.google_recaptcha.recaptcha_secret');

        // Отправляем POST запрос и декодируем результаты ответа
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $value);
        $recaptcha = json_decode($recaptcha);
        return ($recaptcha->success && $recaptcha->score >= 0.1) ?? false;


    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Captcha не прошла';
    }
}
