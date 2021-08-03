<?php
namespace App\Seo;
use App\Seo\Classes\SeoCategoryRender;
use App\Seo\Classes\SeoPostRender;
use App\Seo\Contracts\SeoMetaRender;

abstract class SeoFabricClass
{

    public static function build($type, $data){
        // Здесь нам нужно создать нужный продукт
        switch($type)
        {
            case 'post':
                $metaEntity = new SeoPostRender($data);
                break;

            case 'category':
                $metaEntity = new SeoCategoryRender($data);
                break;
            default:
                throw new \Exception('Не верный тип объекта');
        }

        return $metaEntity->returnMeta();
    }

    public function setData($content)
    {
        // Вызываем фабричный метод для создания объекта Продукта...
        $seoMeta = $this->getSeoMeta();
        return $seoMeta->setData();
      //  $result[] = $seoMeta->returnMeta();
        //return $result;
    }

    abstract public function getSeoMeta(): SeoMetaRender;




}
