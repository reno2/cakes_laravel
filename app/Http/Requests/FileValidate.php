<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileValidate extends FormRequest
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
            'title'   => "unique:articles|required",
            'image'   => "max:5",
           // 'image'   => "required|max:5",
            'image.*' => "mimes:png,jpg,jpeg|max:20000",
        ];
    }


    public function messages()
    {
        return [
            'title.required' => 'Название объязательно',
            'title.unique' => 'Название уже существует',
            'image.max'      => 'Не более 5 файлов',
            'image.required' => 'Загрузка файла объязательна',
            'image.*.mimes'  => 'Только разрешённые форматы'
        ];
    }
}
