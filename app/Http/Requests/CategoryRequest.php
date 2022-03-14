<?php

namespace App\Http\Requests;


use App\Rules\StripTags;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function rules () {
        $adsObj = (strpos((string)$this->route()->uri, 'admin') === false) ? 'ad' : 'category';
        $categoryId = (!is_object($this->route($adsObj))) ? $this->route($adsObj) : $this->route($adsObj)->id;
        // dd($categoryId, $this);
        return [
            'title' => [
                'required',
                'max:155',
                Rule::unique('categories', 'title')->ignore($categoryId),
            ],
            'slug' => Rule::unique('categories', 'slug')->ignore($categoryId),
            'image' => "max:1",
            'image.*' => "mimes:png,jpg,jpeg|max:20000",
        ];
    }

    public function messages () {
        return [
            'title.unique' => 'Объявление с таким названием существует',
            'title.required' => 'Название объязательно',
            'title.max' => 'Не более 155 символов',
            'image.max'      => 'Не более 5 файлов',
            'image.required' => 'Загрузка файла объязательна',
            'image.*.mimes'  => 'Только разрешённые форматы',
            'slug.unique' => 'Объявление с таким названием существует',
        ];
    }
}