<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdsRequest extends FormRequest
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
     * @param Request $request
     *
     * @return array
     */
    public function rules()
    {
        //$this->route('ad');
        return [

            'title'   => [
                'required',
                'alpha_dash',
                'max:155',
                Rule::unique('articles', 'title')->ignore($this->route('ad')),
            ],


            'description'   => "required|max:400",
            'weight' => 'regex:/^(\d+){0,2}(\.){0,1}(\d){1,3}$/i'
            //'price'   => "required|max:400",
           // 'categories'=> "required|array|not_in:0",
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
            'title.max' => 'Не более 155 символов',
            'title.alpha_dash' => 'Поле можно содержать только алфавитные символы, цифры, знаки подчёркивания _ и дефисы -',
            'description.required' => 'Поле объязательное',
            'description.max' => 'Максимальное количество 400 символов',
            //'categories.required|not_in' => 'Выбор категории объязателен',
            //'categories.not_in' => 'Выбор категории объязателен',
            'price'   => 'Поле цена объязательно',
            'weight.regex' => 'Не корректный ввод'
//            'title.unique' => 'Название уже существует',
//            'image.max'      => 'Не более 5 файлов',
//            'image.required' => 'Загрузка файла объязательна',
//            'image.*.mimes'  => 'Только разрешённые форматы'
        ];
    }
}
