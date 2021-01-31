<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Article as Model;
use App\Repositories\CoreRepository;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\Models\Media;


class AdsRepository extends CoreRepository
{

    public function getAdsImagesSortByMain(){
        $mediaItem2 =  Media::where('model_id', $ads->id)->orderBy('custom_properties->main', 'desc')->get();
    }
    public function getMainIfIsset(){

    }

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

    public function getAdsSortedDesc($per = 9)
    {
        return $this->startCondition()->orderBy('created_at', 'desc')->paginate($per);
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

    //=================Удалене===================
    //==========================================
    //

    public function removeArticle($ads){
        $ads->delete();
        return true;
    }
    public function removeRelationCategories($ads){
        $ads->categories()->detach();
        return true;
    }
    public function removeRelationTags($ads){
        $ads->tags()->detach();
        return true;
    }
    public function removeFilterValName($ads)
    {
        $ads->filterGroups()->detach();
        $ads->filterValues()->detach();
        return true;
    }



}
