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
            'name' => 'regex:/^[a-zA-Zа-яА-Я0-9\s_]+$/u',
            'contact1' =>  'regex:/^[a-zA-Zа-яА-Я0-9\s]+$/u',
            'address' => 'required|regex:/^[a-zA-Zа-яА-Я0-9\s-]+$/u'
        ];
    }


    public function messages()
    {
        return [
            'name.regex' => 'Только буквы или числа',
            'contact1.regex' => 'Только буквы или числа',
            'address.required' => 'Название объязательно',
            'address.regex' => 'Только буквы или числа "-" пробел ',
        ];
    }
}
