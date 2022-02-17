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
        return $this->startCondition()
                      ->where('published', '1')
                      ->orderBy('sort', 'asc')
                      ->get();
    }

    public function getAllActiveParentItems(){
        return $this->startCondition()
                    ->where('published', '1')
                    ->where('parent', '0')
                    ->orderBy('sort', 'asc')
                    ->get();
    }

    /*
   * @return string
   */
    protected function getModelClass()
    {
        return Model::class;
    }




}
