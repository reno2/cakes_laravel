<?php

namespace App\Http\Requests;
use App\Rules\StripTags;
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

    public function validationData()
    {
        $rr = parent::validationData();
        $rr['title'] = "strip_tags(rr['title'])";
        $gg = '';
        return $rr;
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
        $rr = '';
        return [

            'title'   => [
                'required',
                'max:155',
                Rule::unique('articles', 'title')->ignore($this->route('ad')),
            ],
            'deal_address' => "required|regex:/[а-яА-Я0-9 -]+/",
            'tags' => 'required',
            'description'   => "required|max:1000",
            'weight' => 'regex:/^(\d+){0,2}(\.){0,1}(\d){1,3}$/i',
            'price'   => "required|max:10|regex:/^\d+(\.\d{1,2})?$/",
            'categories'=> "required|array|not_in:0",
          //  'description'   => "required",
           'image'   => "max:5",
           'image.*' => "mimes:png,jpg,jpeg|max:20000",
           'meta_description' => 'max:155',

            // Модерация
            'moderate_text' => 'max:155',
        ];
    }


    public function messages()
    {
        return [
            'title.unique' => 'Объявление с таким названием существует',
            'title.required' => 'Название объязательно',
            'title.max' => 'Не более 155 символов',

            'description.required' => 'Поле объязательное',
            'description.max' => 'Максимальное количество 400 символов',
            //'categories.required|not_in' => 'Выбор категории объязателен',
            'categories.not_in' => 'Выбор категории объязателен',
            'price.required'   => 'Поле цена объязательно',
            'price.regex'   => 'Не верный формат',
            'weight.regex' => 'Не корректный ввод',
            'deal_address.regex' => 'Не корректный ввод',
            'deal_address.required' => 'Название объязательно',
            'tags.required' => 'Необходимо выбрать один тег',
            'tags.regex' => 'Необходимо выбрать один тег',
//            'title.unique' => 'Название уже существует',
            'image.max'      => 'Не более 5 файлов',
            'image.required' => 'Загрузка файла объязательна',
            'image.*.mimes'  => 'Только разрешённые форматы'
        ];
    }
}
