<?php
namespace App\Seo;


use App\Seo\Classes\SeoCategoryRender;
use App\Seo\Classes\SeoPostRender;
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
                $entity = new SeoPostRender($data);
                break;

            case 'category':
                $entity = new SeoCategoryRender($data);
                break;
            default:
                throw new \Exception('Не верный тип объекта');
        }
        $this->seoEntity = $entity;
        $this->seoEntity->setData();

    }

    /**
     * Сохраняем в массиве тег и значение для
     * Статического вывода
     * @param $tag
     * @param $tagValue
     */
    public function setTag($tag, $tagValue){
        $this->staticTags[$tag] = $tagValue;
    }

    /**
     * Выводим теги без шаблонов
     * @param $field
     * @return Factory|View
     */
    public function getStaticTag($field){
        return view("seo." . $field, ['tag' => $this->staticTags[$field]]);
    }

    /**
     * Передаём в представление по имени тега.
     * Представление должно быть создано
     * @param $field
     * @return Factory|View
     */
    public function getData($field){
        if($this->seoEntity && $this->seoEntity->returnMeta($field)) {
            $data = $this->seoEntity->returnMeta($field);
            return view("seo." . $field, ['tag' => $data]);
        }
    }
}
