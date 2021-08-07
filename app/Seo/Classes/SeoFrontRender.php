<?php

namespace App\Seo\Classes;

use App\Seo\Abstracts\SeoAbstractRender;
use App\Seo\Interfaces\SeoStaticInterface;
use Illuminate\Support\Facades\DB;

/**
 * Этот обработчик главной страницы.
 */
class SeoFrontRender extends SeoAbstractRender implements SeoStaticInterface
{

    public function __construct () {
        $this->type = 'front';
    }

    public function setData ($data) {
        $this->data = $data;
        $this->prepareData();
    }

    public function renderTag ($field) {
        return $this->toRender[$field];
    }

}