<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Article as Model;
use App\Repositories\CoreRepository;
use Illuminate\Support\Facades\Auth;

class AdsRepository extends CoreRepository
{


    public function getForEdit($id){
        return $this->startCondition()->find($id);
    }
    /*
   * @return string
   */
    protected function getModelClass()
    {
        return Model::class;
    }

    public function getAdsSortedDesc()
    {
        return $this->startCondition()->orderBy('created_at', 'desc')->get();
    }

    public function removeFilterValName($ads)
    {
        $ads->filterGroups()->delete();
        $ads->filterValues()->delete();
        return true;
    }

    public function setRelationAttrs(array $values, $ads)
    {
         $ads->filterGroups()->attach(array_keys($values));
         $ads->filterValues()->attach($values);
        return true;
    }

    public function setRelationCategories(array $values, $ads)
    {
         $ads->categories()->attach($values);
        return true;
    }

    public function setRelationTags(array $values, $ads)
    {
        $ads->tags()->attach($values);
        return true;
    }


}
