<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileValidate extends FormRequest
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
            'name' => 'regex:/^[а-яёa-z0-9 ]+/i',
            'address' => 'required|regex:/^[а-я -]+/i'

        ];
    }


    public function messages()
    {
        return [
            'name.regex' => 'Только буквы или числа',
            'address.required' => 'Название объязательно',
            'address.regex' => 'Только буквы',
        ];
    }
}
