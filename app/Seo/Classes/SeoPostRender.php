<?php

namespace App\Seo\Classes;

use App\Seo\Contracts\SeoMetaRender;

/**
 * Этот Конкретный Продукт реализует API Facebook.
 */
class SeoPostRender implements SeoMetaRender
{
    private $type, $data;

    public function __construct(string $type, array $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    public function setData () {
        return [1,3,6];
        // TODO: Implement getFields() method.
    }

//    public function getTpl () {
//        // TODO: Implement getTpl() method.
//    }

    public function returnMeta () {
        // TODO: Implement returnMeta() method.
    }
}