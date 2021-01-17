<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdsRequest extends FormRequest
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
            //'title'   => "unique:articles|required",
            //'description'   => "required|max:400",
            'categories'=> "required|array|not_in:0",

          //  'description'   => "required",
//            'image'   => "max:5",
//            'image.*' => "mimes:png,jpg,jpeg|max:20000",
        ];
    }


    public function messages()
    {
        return [
            'title.unique' => 'Объявление с таким названием существует',
            'title.required' => 'Название объязательно',
            'description.required' => 'Поле объязательное',
            'description.max' => 'Максимальное количество 400 символов',
            'categories.required|not_in' => 'Выбор категории объязателен',
            'categories.not_in' => 'Выбор категории объязателен',
//            'title.unique' => 'Название уже существует',
//            'image.max'      => 'Не более 5 файлов',
//            'image.required' => 'Загрузка файла объязательна',
//            'image.*.mimes'  => 'Только разрешённые форматы'
        ];
    }
}
