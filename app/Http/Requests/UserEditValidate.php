<?php

namespace App\Http\Requests;


use App\Rules\NotEmail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Password;

class UserEditValidate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize () {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules () {
        $userId = $this->route('user');

        return [
            'new_password' => [
                'required',
                'min:8',
                'regex:/[A-Za-z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            'new_confirm_password' => 'required|min:6|same:new_password',
            'email' => 'email|unique:users,email,' . $userId,
        ];
    }

    public function messages () {
        return [
            'email.email' => 'Некорректный вод',
            'email.unique' => 'Email существует',
            'new_password.min' => 'Минимальная длинна 6',
            'new_password.required' => 'Объязательно',
            'new_password.regex' => 'Не верный формат Латинские буквы в верхнем или нижнем регистре цифры и спец символы $!%*#?&',
            'new_confirm_password.min' => 'Минимальная длинна 6',
            'new_confirm_password.same' => 'Пароли не совпадают',
        ];
    }
}
