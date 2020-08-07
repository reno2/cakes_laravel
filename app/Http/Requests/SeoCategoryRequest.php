<?php

namespace App\Http\Requests;

class SeoCategoryRequest extends SeoRequest{


    public function rules()
    {
        return [
            'title' => 'max:255',
            'description' => 'max:255',
            'keywords' => 'max:255'
        ];
    }

    public function message()
    {
        return [
            'title' => 'Не более 255 символов',
            'description' => 'Не более 255 символов',
            'keywords' => 'Не более 255 символов',
        ];
    }
}
