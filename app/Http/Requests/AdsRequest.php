<?php

namespace App\Http\Requests;


use App\Rules\FindLinks;
use App\Rules\NotEmail;
use App\Rules\StripTags;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdsRequest extends FormRequest
{

    public function stripTags ($fields, $validationData) {
        foreach ($fields as $field) {
            $validationData[$field] = strip_tags($validationData[$field]);
        }
        return $validationData;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize () {
        return true;
    }

    public function validationData () {
        return $this->stripTags(['title', 'description'], parent::validationData());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param Request $request
     *
     * @return array
     */
    public function rules () {
        $adsObj = (strpos((string)$this->route()->uri, 'admin') === false) ? 'ad' : 'article';
        $adsId = (!is_object($this->route($adsObj))) ? $this->route($adsObj) : $this->route($adsObj)->id;
        return [
            'user_id' => "required",
            'title' => [
                'required',
                'max:155',
                'regex:/^[-а-яА-Я0-9\sa-zA-Z]+$/umi',
                new FindLinks,
            ],
            'deal_address' => [
                'required',
                'regex:/^[\.а-яА-Я0-9\s\-\,]+$/u',
                new NotEmail,
            ],
            'tags' => 'required',
            'description' => [
                'required',
                'max:1000',
                'regex:/^[\.\,\'\"_а-яёА-Я0-9a-z\s-]+$/umi',
                new FindLinks,
            ],
            'weight' => 'regex:/^(\d+){0,2}(\.){0,1}(\d){1,3}$/i',
            'price' => "required|max:10|regex:/^\d+(\.\d{1,2})?$/",
            'categories' => "required|array|not_in:0",
            'image' => "max:5",
            'image.*' => "mimes:png,jpg,jpeg|max:20000",
            'meta_description' => 'max:155',
            'moderate_text' => 'max:155',
        ];
    }


    public function messages () {
        return [
            'user_id.required' => 'Владелец объязательно',
            'title.unique' => ':attribute - Объявление с таким названием существует',
            'title.required' => ':attribute - Название объязательно',
            'title.max' => ':attribute - Не более 155 символов',
            'title.regex' => ':attribute - Разрешено Буквы цыфры пробел и дефис',
            'description.required' => 'Поле объязательное',
            'description.max' => 'Максимальное количество 400 символов',
            'categories.not_in' => ':attribute - Выбор категории объязателен',
            'price.required' => 'Поле цена объязательно',
            'price.regex' => 'Не верный формат',
            'weight.regex' => 'Не корректный ввод',
            'deal_address.regex' => ':attribute - Не корректный ввод',
            'deal_address.required' => ':attribute - Адрес сделки объязательно',
            'tags.required' => 'Необходимо выбрать один тег',
            'tags.regex' => 'Необходимо выбрать один тег',
            'image.max' => 'Не более 5 файлов',
            'image.required' => 'Загрузка файла объязательна',
            'image.*.mimes' => 'Только разрешённые форматы',
        ];
    }

    public function attributes () {
        return [
            'title' => 'Название',
            'categories' => 'Категория',
            'deal_address' => 'Место сделки',
        ];
    }
}
