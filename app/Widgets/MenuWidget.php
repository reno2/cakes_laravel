<?php
namespace App\Widgets;

use App\Widgets\Contract\ContractWidget;
use App\Menu;
use App\Repositories\CategoryRepository;

class MenuWidget implements ContractWidget
{
    public function getActiveItems(){

    }

    public function execute()
    {
        $items = new CategoryRepository();
        $data = $items->getAllActiveItems()
                      ->keyBy('id')
                      ->toArray();

        if(!$data) return [];

        $url = '/';
        if(\Request::segment(2)){
            $url = \Request::segment(2);
        }
        foreach($data as &$item){
            $item['is_active'] = (strpos($item['slug'], $url) !== false) ? true : false ;
            $item['url'] = implode('/', ['', 'category', $item['slug'], '']);
            if($item['parent_id'] !== 0) {
                $data[$item['parent_id']]['CHILDREN'][] = $item;
                unset($data[$item['id']]);
            }
        }

    //    dd($data);
        return view('Widgets::menu', [
            'data' => $data
        ]);
    }
}
