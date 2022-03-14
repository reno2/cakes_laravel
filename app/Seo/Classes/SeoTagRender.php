<?php

namespace App\Seo\Classes;

use App\Seo\Abstracts\SeoAbstractRender;
use App\Seo\Interfaces\SeoStaticInterface;
use Illuminate\Support\Facades\DB;

/**
 * Этот обработчик страницы категорий.
 */
class SeoTagRender extends SeoAbstractRender implements SeoStaticInterface{


    public function __construct () {
        $this->type = 'tag';
    }

    public function setData ($data) {
        $this->data = $data;
        $this->prepareData();
    }

    public function renderTag ($field) {
        return $this->toRender[$field];
    }

}
