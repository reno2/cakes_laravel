<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Article as Model;
use App\Repositories\CoreRepository;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\Models\Media;
use App\Models\Profile;


class AdsRepository extends CoreRepository
{
    /*
    * @param ind user Id
    * @return Collection
    * Передаём id пользователя и
    * возвращаем коллекцию со связами
    */
    public function getByCurrentProfileFavoritesAdsSortedDesc($ids, $per = 9) {
       // $ids = (new ProfileRepository())->getFavoritesArray($id);
        return $this->startCondition()->whereIn('id', $ids)->orderBy('created_at', 'desc')->paginate($per);
    }

    /*
    * @param User Id
    * @return Collection
    * Возвращаем коллекцию объявлений пользователя
    */
    public function getByCurrentProfileAdsSortedDesc($user, $per = 9) {
        $data = $this->startCondition()->where('user_id', $user)->orderBy('created_at', 'desc')->paginate($per);
        return $data;

    }

    public function getAdsImagesSortByMain(){
        $mediaItem2 =  Media::where('model_id', $ads->id)->orderBy('custom_properties->main', 'desc')->get();
    }
    public function getMainIfIsset(){

    }

    /*
     * params $ads Article
     * re
     */
    public function getUserProfileFirst($ads){
        return $ads->user->profiles->first();
    }

    /*
     *
     */
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

    /*
     * @param Article Id
     * @return Array
     * Возвращаем массив данных
     */
    public function getAdsImages($id){
        $mediaAdsCollection = Media::where('model_id', $id)->orderBy('custom_properties->main', 'desc')->get();
        if(!$mediaAdsCollection->isEmpty()){
            $adsFiles = [];
            foreach($mediaAdsCollection as $key=>$mediaItem){
                $adsFiles[$mediaItem->file_name]['id'] = $mediaItem->id;
                $adsFiles[$mediaItem->file_name]['main'] = ($mediaItem->getCustomProperty('main')) ?? false ;
                $adsFiles[$mediaItem->file_name]['src'] = $mediaItem->getUrl('thumb');
                $adsFiles[$mediaItem->file_name]['file_name'] = $mediaItem->file_name;
            }
            //return json_encode($adsFiles);
            return $adsFiles;
        }
    }

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
