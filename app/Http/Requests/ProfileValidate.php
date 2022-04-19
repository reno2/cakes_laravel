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
            'contact1' =>  'regex:/^[+()\-0-9\s]+$/u',
            'address' => 'required|regex:/^[a-zA-Zа-яА-Я0-9\s-]+$/u'
        ];
    }


    public function messages()
    {
        return [
            'name.regex' => ':attribute - Только буквы или числа',
            'contact1.regex' => ':attribute - Только числа, пробел и тире',
            'address.required' => ':attribute - Название объязательно',
            'address.regex' => ':attribute - Только буквы или числа "-" пробел ',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Имя',
            'address' => 'Адрес',
            'contact1' => 'Контактный телефон',
        ];
    }
}
