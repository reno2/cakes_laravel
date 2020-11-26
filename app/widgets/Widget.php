<?php


namespace App\widgets;


class Widget
{
    protected $widgets; //массив доступных виджетов config/widgets.php
    protected $tpl;
    public function __construct(){
        $this->widgets = config('widgets');
    }

    public function show($obj, $data =[]){
        //Есть ли такой виджет в $obj название фильтра, которое указано в конфиге
        if(isset($this->widgets[$obj])){
            //создаем его объект передавая параметры в конструктор
            $obj = \App::make($this->widgets[$obj], $data);
            //возвращаем результат выполнения
            return $obj->execute($data);
        }
    }
}
