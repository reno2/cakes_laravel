<?php
namespace App\Seo;
use App\Seo\Contracts\SeoMetaRender;

abstract class SeoFabricClass
{
    public function setData($content)
    {
        // Вызываем фабричный метод для создания объекта Продукта...
        $seoMeta = $this->getSeoMeta();
        $result[] = $seoMeta->setData();
      //  $result[] = $seoMeta->returnMeta();
        return $result;
    }

    abstract public function getSeoMeta(): SeoMetaRender;
}
