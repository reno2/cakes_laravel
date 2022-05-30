<?php

namespace App\Repositories;


use App\Models\Article;

use Carbon\Carbon;
use Hamcrest\Type\IsBoolean;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Article as Model;
use App\Repositories\CoreRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\Models\Media;
use App\Models\Profile;


class AdsRepository extends CoreRepository
{

    /**
     * @param $userId
     * @return mixed
     * Возвращаем количество статей пользователя
     * Не удалённых
     */
    public function countByUser($userId){
        return $this->startCondition()::where('user_id', $userId)->count();
    }

    public function forFrontDetail($id){
        $cachceKey = "front_ad_detail_{$id}";
        return Cache::remember($cachceKey, 60*15, function () use($id) {
            $detailAds = $this->startCondition()::where('id', $id)
                        ->where('published', 1)
                        ->where('moderate', 1)
                        ->first();

            if (!$detailAds) return false;

            $detailAds['description'] = setLineBreaks($detailAds['description']);
            $detailAds['price'] = (!$detailAds['price']) ? config('common.deal_price') : $detailAds['price'] . ' руб.';
            return $detailAds;
        });
    }

    public function forFrontPage () {
       // Cache::forget('front_ads');
        return Cache::remember('front_ads', 60*15, function () {
            return $this->startCondition()::where('published', 1)
                        ->where('moderate', 1)
                        ->where('on_front', 1)
                        ->with('categories', 'tags')
                        ->orderBy('sort', 'asc')->orderBy('id', 'asc')->take(20)->get();
        });
    }


    public function allForEditWithPaginateAndSort ($sortParam = NULL, $sortType = NULL, $filter = false, $perPage = 10) {
        $order = 'sort';
        $sort = 'asc';

        if ($sortParam) {
            $order = $sortParam;
        }

        if ($sortType) {
            $sort = $sortType;
        }

        if ($filter === 'with_deleted') {
            return $this->startCondition()::onlyTrashed()
                        ->orderBy($order, $sort)
                        ->with('media', 'tags')
                        ->paginate($perPage);
        }

        if ($filter === 'moderate') {
            return $this->startCondition()::orderBy($order, $sort)
                        ->where('moderate', 0)
                        ->with('media', 'tags')
                        ->paginate($perPage);
        }


        return $this->startCondition()::orderBy($order, $sort)
                    ->orderBy('sort', 'asc')
                    ->with('media', 'tags')
                    ->paginate($perPage);

    }


    public function notModerated () {
        return $this->startCondition()::where('moderate', 0)->get();
    }

    public function disableUserAds ($userId) {
        $this->startCondition()::where('user_id', $userId)
             ->update(['published' => 0]);
    }

    public function getTodayAds ($count = 10) {
        $records = Article::whereDate('created_at', Carbon::today())->take($count)->get();
        if ($records->isEmpty()) return 0;
        return $records;
    }

    /*
    * @param ind user Id
    * @return Collection
    * Передаём id пользователя и
    * возвращаем коллекцию со связами
    */
    public function getByCurrentProfileFavoritesAdsSortedDesc ($ids, $per = 9) {
        return $this->startCondition()->whereIn('id', $ids)->orderBy('created_at', 'desc')->paginate($per);
    }

    /*
    * @param User Id
    * @return Collection
    * Возвращаем коллекцию объявлений пользователя
    */
    public function getByCurrentProfileAdsSortedDesc ($where, $page = 'page', $user = NULL, $per = 10) {
        if (!is_array($where)) $where = [['user_id', $user]];
        $data = $this->startCondition()->where($where)->orderBy('created_at', 'desc')->paginate($per, ['*'], $page);
        return $data;

    }

    public function getAdsImagesSortByMain () {
        $mediaItem2 = Media::where('model_id', $ads->id)->orderBy('custom_properties->main', 'desc')->get();
    }

    public function getMainIfIsset () {

    }

    /*
     * params $ads Article
     * re
     */
    public function getUserProfileFirst ($ads) {
        return $ads->user->profiles->first();
    }

    /*
     *
     */
    public function getForEdit ($id) {
        return $this->startCondition()->find($id);
    }

    /*
   * @return string
   */
    protected function getModelClass () {
        return Model::class;
    }

    public function getAdsSortedDesc ($per = 9) {
        return $this->startCondition()->orderBy('created_at', 'desc')->paginate($per);
    }

    public function setRelationAttrs (array $values, $ads) {
        $ads->filterGroups()->attach(array_keys($values));
        $ads->filterValues()->attach($values);
        return true;
    }

    public function setRelationCategories (array $values, $ads) {
        $ads->categories()->attach($values);
        return true;
    }

    public function setRelationTags (array $values, $ads) {
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
    public function getAdsImages ($id) {
        $mediaAdsCollection = Media::where('model_id', $id)->orderBy('custom_properties->main', 'desc')->get();
        if (!$mediaAdsCollection->isEmpty()) {
            $adsFiles = [];
            foreach ($mediaAdsCollection as $key => $mediaItem) {
                $adsFiles[$mediaItem->file_name]['id'] = $mediaItem->id;
                $adsFiles[$mediaItem->file_name]['main'] = ($mediaItem->getCustomProperty('main')) ?? false;
                $adsFiles[$mediaItem->file_name]['src'] = $mediaItem->getUrl('thumb');
                $adsFiles[$mediaItem->file_name]['file_name'] = $mediaItem->file_name;
            }
            //return json_encode($adsFiles);
            return $adsFiles;
        }
    }

    public function removeArticle ($ads) {
        $ads->delete();
        return true;
    }

    public function removeRelationCategories ($ads) {
        $ads->categories()->detach();
        return true;
    }

    public function removeRelationTags ($ads) {
        $ads->tags()->detach();
        return true;
    }

    public function removeFilterValName ($ads) {
        $ads->filterGroups()->detach();
        $ads->filterValues()->detach();
        return true;
    }



}
