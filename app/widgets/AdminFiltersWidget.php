<?php
namespace App\Widgets;

use App\Widgets\Contract\ContractWidget;
use App\Menu;

class AdminFiltersWidget implements ContractWidget
{
    public $filter;
    public $tpl = 'Widgets::adminfiltersGrop';

    public function __construct($tpl, $filter)
    {
        // parent::__construct($data);
        $this->tpl    = $tpl;
        $this->filter = $filter;
    }

    protected function getAttrs()
    {
        $data  = \DB::table('values')->get();
        $attrs = [];
        foreach ($data as $key => $value) {
            $attrs[$value->property_id][$value->id] = $value->key;
        }

        return $attrs;

    }

    protected function getGroups()
    {
        $data   = \DB::table('properties')->get();
        $groups = [];
        foreach ($data as $key => $value) {
            $groups[$value->id] = $value->title;
        }

        return $groups;
    }

    public function getFilter()
    {
       return  $this->filter;
    }

    public function execute()
    {
        if($this->getAttrs() && $this->getGroups() ) {
            return view($this->tpl, [
                'attrs'  => $this->getAttrs(),
                'groups' => $this->getGroups(),
                'filter' => $this->getFilter()
            ]);
        }
    }
}
