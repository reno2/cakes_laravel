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
        $data = $items->getAllActiveItems()
                      ->toArray();

        if (!$data) return [];

        $url = '/';
        if (\Request::segment(2)) {
            $url = \Request::segment(2);
        }
        $cnt = 0;

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
            if ($cnt > 4) {
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
