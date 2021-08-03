<?php

namespace App\Seo\Classes;

use App\Seo\Contracts\SeoMetaRender;

/**
 * Этот Конкретный Продукт реализует API Facebook.
 */
class SeoCategoryRender implements SeoMetaRender{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function setData () {
        // TODO: Implement setData() method.
    }

    public function returnMeta () {
        // TODO: Implement returnMeta() method.
    }
}
