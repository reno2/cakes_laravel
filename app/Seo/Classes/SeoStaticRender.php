<?php


namespace App\Seo\Classes;


use App\Seo\Interfaces\SeoStaticInterface;

class SeoStaticRender implements SeoStaticInterface
{
    private $toRender = [];

    /**
     * @param $data
     * Добавление в массив значение статического тега
     */
    public function setData ($data) {
        list($tag, $value) = $data;
        $this->toRender[$tag] = $value;
    }

    /**
     * @param $field
     * @return mixed|null
     */
    public function renderTag($field) {
        return ($this->toRender[$field]) ?? null;
    }
}