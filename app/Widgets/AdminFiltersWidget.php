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
        $data  = \DB::table('property_values')->get();
        if($data ) {
            $attrs = [];
            foreach ($data as $key => $value) {
                $attrs[$value->property_name_id][$value->id] = $value->key;
            }

            return $attrs;
        }
        else
            return false;
    }

    protected function getGroups()
    {
        $data   = \DB::table('property_names')->get();
        if($data ) {
            $groups = [];
            foreach ($data as $key => $value) {
                $groups[$value->id] = $value->title;
            }

            return $groups;
        }else
            return false;
    }

    public function getFilter()
    {
       return  $this->filter;
    }

    public function execute()
    {
        //dd($this->getGroups());
        if($this->getAttrs() && $this->getGroups() ) {
            return view($this->tpl, [
                'attrs'  => $this->getAttrs(),
                'groups' => $this->getGroups(),
                'filter' => $this->getFilter()
            ]);
        }
    }
}
