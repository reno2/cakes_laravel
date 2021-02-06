<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditValidate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'new_password' => 'required|min:6',
            'new_confirm_password' => 'required|min:6|same:new_password',
            'email' =>'email|unique:users,email',
        ];
    }


    public function messages()
    {
        return [
            'email.email' => 'Некорректный вод',
            'email.unique' => 'Email существует',
            'new_password.min' => 'Минимальная длинна 6',
            'new_confirm_password.min' => 'Минимальная длинна 6',
            'new_confirm_password.same' => 'Пароли не совпадают',
        ];
    }
}
