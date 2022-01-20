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
        $data = $items->getAllActiveItems();
    //    dd($data);
        return view('Widgets::menu', [
            'data' => $data
        ]);
    }
}
