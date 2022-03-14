<?php

namespace App\Seo\Abstracts;


use Illuminate\Support\Facades\DB;
use Mockery\Exception;

abstract class SeoAbstractRender
{
    protected $varsToReplace = ['title', 'description'];

    protected $fillable = [
        'title',
        'h1',
        'description',
    ];
    protected $data;
    protected $type;
    protected $virtual = [];
    protected $toRender = [];


    /**
     * @param $field string Название шалона подсканоки
     * @param null $fieldTpl Значенеи шаблона подстановки
     * @return mixed
     */
    public function getTitle ($field, $fieldTpl = NULL) {
        // Если шаблон пустой возвращает значение из модели
        if (!$fieldTpl) return $this->data[$fieldTpl];
        foreach ($this->varsToReplace as $varToReplace) {
            $fieldTpl = preg_replace("/#" . $varToReplace . "#/", $this->data[$varToReplace], $fieldTpl);
        }

        return $fieldTpl;

    }

    /**
     * @param $field string Название шалона подсканоки
     * @param null $fieldTpl Значенеи шаблона подстановки
     * @return mixed
     */
    public function getH1 ($field, $fieldTpl = NULL) {
        // Если шаблон пустой возвращает значение из модели
        if (!$fieldTpl) return $this->data[$fieldTpl];

        foreach ($this->varsToReplace as $varToReplace) {
            $fieldTpl = preg_replace("/#" . $varToReplace . "#/", $this->data[$varToReplace], $fieldTpl);
        }

        return $fieldTpl;
    }

    /**
     * @param $field string Название шалона подсканоки
     * @param null $fieldTpl Значенеи шаблона подстановки
     * @return mixed
     */
    public function getDescription ($field, $fieldTpl = NULL) {
        // Если шаблон пустой возвращает значение из модели
        if (!$fieldTpl) return $this->data[$fieldTpl];

        foreach ($this->varsToReplace as $varToReplace) {
            $fieldTpl = preg_replace("/#" . $varToReplace . "#/", $this->data[$varToReplace], $fieldTpl);
        }

        return $fieldTpl;
    }


    /**
     * Основной метод по подготовке данных и передачи их в нужные геттеры.
     * Если Геттера нет то возвращает значение из даты
     */
    protected function prepareData (): void {
        try {
            $rawData = DB::table('seo')->where('type', $this->type)->first();
            $rawData = ((array)$rawData) ?: [];
            $metaResult = [];
            foreach ($this->fillable as $field) {

                // Если нет шаблона и виртуальное поле
                if (array_key_exists($field, $this->virtual) && !$rawData[$field]) {
                    $metaResult[$field] = $this->data[$this->virtual[$field]];
                    continue;
                }

                // Если есть сео шаблон для поля
                if ($rawData && $rawData[$field]) {
                    $method = 'get' . ucfirst($field);
                    if (method_exists($this, $method)) {
                        $metaResult[$field] = $this->$method($field, $rawData[$field]);
                        continue;
                    }
                }

                $metaTpl = ($this->data[$field]) ?? $field;
                $metaResult[$field] = $metaTpl;
            }

            $this->toRender = $metaResult;
        } catch (Exception $exception) {

        }
    }

}
