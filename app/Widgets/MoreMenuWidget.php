<?php

namespace App\Widgets;


use App\Widgets\Contract\ContractWidget;
use App\Menu;
use App\Repositories\CategoryRepository;

class MoreMenuWidget implements ContractWidget
{
    public function getActiveItems () {

    }

    public function execute () {
        $items = new CategoryRepository();
        $data = $items->getAllActiveItems();


        $excludeUrls = ['login'];
        $curUrl = \Request::segment(1);

        if(in_array($curUrl, $excludeUrls) || !$data) return view('Widgets::moreMenu', [
            'data' => [],
        ]);

        


        $url = '/';
        if (\Request::segment(2)) {
            $url = \Request::segment(2);
        }
        $data = $data->toArray();
        $cnt = 0;
        $limit = 4;
        $lastItem = [
            'title' => 'Ещё',
            'CHILDREN' => [],
            'is_active' => false,
            'url' => '',
            'is_more' => true,
        ];
        foreach ($data as $key => &$item) {

            $item['is_active'] = (strpos($item['slug'], $url) !== false) ? true : false;
            $item['url'] = implode('/', ['', 'category', $item['slug'], '']);
            if ($cnt > $limit) {
                $lastItem['CHILDREN'][] = $item;
                unset($data[$key]);
            }

            $cnt++;
        }
        if (count($lastItem['CHILDREN'])) $data[] = $lastItem;
        //dd($data);
        return view('Widgets::moreMenu', [
            'data' => $data,
        ]);
    }
}
