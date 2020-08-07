<?php
namespace App\Seo;

use App\Seo;
use Illuminate\Support\Facades\DB;

class Seometa{
    protected $type;
    protected $data = [];
    protected $renderArray = [];
    protected $needle = ['title', 'description', 'keywords', 'h1'];
    protected $post;
    protected $categoryTplValues = ['title', 'description'];

    /**
     * Вызывает нужный класс для заполнения
     * @param $type
     * @param $data
     */
    public function setTags($type, $data) : void {
        // Сделать Вызываем нужный контроллер
        // Пока метод
        $this->getTplValues($data);

        $this->setCategoryTags();


        $this->type = $type;

    }

    public function getTplValues($post){
        $result = [];
        foreach ($post as $key => $val){
            //$newKey = str_replace( "meta_", "", $key);
            if(in_array($key, $this->categoryTplValues))
                $result[$key] = $val;
        }
        $this->post =  $result;
    }


    /**
     * Заполняем класс полями из базы
     * и значениями текущей категории
     *
     */
    public function setCategoryTags() : void {
        $category = $this->post;
        $tags = DB::table('seo')->where('type', 'category')->first();
        $r = [];
        foreach ($tags as $key=>$seoTpl){

            if(!in_array($key, $this->needle) || !$seoTpl) continue;
           $this::$tpl = $seoTpl;
            $method = 'set'.$key;
            if (method_exists($this, $method)) {
            // прогоняем шаблон сео поля через доступные переменные поста
                foreach ($this->post as $varName=>$varVal)
                {
                    $seoTpl =  preg_replace ( '/#'.$varName.'#/', $varVal, $seoTpl);
                    //$this->_setKeywords($key, $seoTpl, $varName, $varVal);
                }
                $this->renderArray[$key] = $seoTpl;
                $t= '';
                   // $mainTpl = $this->$method($key, $mainTpl, $varName, $varVal);
            }
        }

    }
    static $tpl;
    public function setKeywords($key, $seoTpl, $needleName, $toValue){

        $this::$tpl = $value = str_replace( "#".$needleName."#", $toValue, $seoTpl);
        $this->renderArray[$key] = $value;

    }

    public function setTitle($key, $seoTpl, $needleName, $toValue){
        $value = str_replace( "#".$needleName."#", $toValue, $seoTpl);
        $this->renderArray[$key] = $value;
    }

    public function setDescription($key, $seoTpl, $needleName, $toValue){
        $value = str_replace( "#".$needleName."#", $toValue, $seoTpl);
        $this->renderArray[$key] = $value;
    }

    public function render()
    {
        $tag = Seo::where('type', $this->type)->first();

        return view('seo.title', ['tags'=> $tag, 'data'=> $this->data]);
    }


    public function renderTag($name){

        if(isset($this->renderArray[$name]) && !empty($this->renderArray[$name])){

            return view("seo.".$name, ['tag'=> $this->renderArray[$name]]);
        }
    }









}
