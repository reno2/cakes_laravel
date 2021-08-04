<?php

namespace App\Seo\Classes;

use App\Seo\Contracts\SeoMetaRender;
use Illuminate\Support\Facades\DB;

/**
 * Этот Конкретный Продукт реализует API Facebook.
 */
class SeoPostRender implements SeoMetaRender
{
    private $data;
    private $fillable = [
        'title', 'h1', 'description'
    ];
    private $virtual = ['h1'=> 'title'];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function setData () {
        return [1,3,6];
        // TODO: Implement getFields() method.
    }

    /**
     * @param $field string Название шалона подсканоки
     * @param null $fieldTpl Значенеи шаблона подстановки
     * @return mixed
     */
    public function getTitle ($field, $fieldTpl = null) {
        // Если шаблон пустой возвращает значение из модели
        if(!$fieldTpl) return $this->data[$fieldTpl];

        return preg_replace('/#' . $field . '#/', $this->data[$field], $fieldTpl);
    }


    private function isSeoVars(){

        $rawData = DB::table('seo')->where('type', 'post')->first();
        $rawData = ((array)$rawData) ?: [];
        $metaResult = [];
        foreach ($this->fillable as $field){
            // Если нет шаблона и виртуальное поле
            if(array_key_exists($field, $this->virtual) && !$rawData[$field]) {
                $metaResult[$field] = $this->data[$this->virtual[$field]];
                continue;
            }

            // Если есть сео шаблон для поля
           if($rawData[$field]){
               $method = 'get'.ucfirst($field);
               if(method_exists($this, $method)) {
                   $metaResult[$field] = $this->$method($field, $rawData[$field]);
                   continue;
               }
           }

           $metaTpl = $this->data[$field];
           $metaResult[$field] = $metaTpl;
         }
        //dd($metaResult);
        return $metaResult;

    }



    public function returnMeta () {
       $this->prepareData();
        return [
            'title' => 'some title',
            'description' => 'description'
        ];
    }

    private function prepareData () {
        $this->isSeoVars();
    }
}