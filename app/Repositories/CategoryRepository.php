<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Category as Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\Models\Media;
use App\Models\Profile;


class CategoryRepository extends CoreRepository
{

    public function getAllActiveItems(){
        $items = $this->startCondition()
                      ->where('published', '1')
                      ->orderBy('sort', 'asc')
                      ->get()
                      ->keyBy('id')
                      ->toArray();
        if(!$items) return false;

        $url = '/';
        if(\Request::segment(2)){
            $url = \Request::segment(2);
        }
        foreach($items as &$item){

            //dd($item);
            $item['is_active'] = (strpos($item['slug'], $url) !== false) ? true : false ;
            $item['url'] = implode('/', ['', 'category', $item['slug'], '']);
            if($item['parent_id'] !== 0) {
                $items[$item['parent_id']]['CHILDREN'][] = $item;
                unset($items[$item['id']]);
            }

        }
        return $items;
    }

    /*
   * @return string
   */
    protected function getModelClass()
    {
        return Model::class;
    }




}
