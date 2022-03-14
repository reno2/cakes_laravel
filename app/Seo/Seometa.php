<?php
namespace App\Seo;


use App\Seo\Classes\SeoCategoryRender;
use App\Seo\Classes\SeoFrontRender;
use App\Seo\Classes\SeoPostRender;
use App\Seo\Classes\SeoTagRender;
use App\Seo\Classes\SeoStaticRender;
use App\Seo\Interfaces\SeoRender;
use App\Seo\Interfaces\SeoStaticInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class Seometa{

    protected $type;
    protected $data = [];
    protected $seoEntity = null;
    protected $staticTags = [];


    /**
     * Вызывает нужный класс для заполнения |
     * Простая фабрика
     * @param $type
     * @param $data
     * @return array|void
     * @throws \Exception
     */
    public function setData($type, $data){
        // Здесь нам нужно создать нужный продукт
        switch($type)
        {
            case 'post':
                $entity = new SeoPostRender;
                break;

            case 'category':
                $entity = new SeoCategoryRender;
                break;

            case 'front':
                $entity = new SeoFrontRender;
                break;

            case 'tag':
                $entity = new SeoTagRender;
                break;

            default:
                throw new \Exception('Не верный тип объекта');
        }
        $this->seoEntity = $entity;
        $this->seoEntity->setData($data);

    }

    /**
     * Сохраняем в массиве тег и значение для
     * Статического вывода
     * @param $tag
     * @param $tagValue
     */
    public function setStaticTag($tag, $tagValue)  {

        if (!$this->seoEntity || !($this->seoEntity instanceof SeoStaticInterface) )
            $this->seoEntity = new SeoStaticRender;

        $this->seoEntity->setData([$tag, $tagValue]);
    }



    /**
     * Выводим теги без шаблонов
     * @param $field
     * @return Factory|View
     */
    public function getStaticTag($field){
        if($this->seoEntity && $this->seoEntity->renderTag($field)) {
            $data = $this->seoEntity->renderTag($field);
            return view("seo." . $field, ['tag' => $data]);
        }
    }


    /**
     * Передаём в представление по имени тега.
     * Представление должно быть создано
     * @param $field
     * @return Factory|View
     */
    public function getData($field){
        if($this->seoEntity && $this->seoEntity->renderTag($field)) {
            $data = $this->seoEntity->renderTag($field);
            return view("seo." . $field, ['tag' => $data]);
        }
    }
}
