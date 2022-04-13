<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Profile as Model;
use App\Repositories\CoreRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Repositories\UserRepository;
use Mockery\Exception;

class ProfileRepository extends CoreRepository
{

    /*
   * @return Collection - $ads возвращает коллекию отложенных объявлений
   * Получаем связанный профиль пользователя
   * Получаем из базы избранное
   * Получаем из репозитория объявлений, коллекцию с пагинацией
   */
    public function favoritesListAuth()
    {
        $user     = Auth::user();
        $profile  = (new userRepository)->getUserProfileEdit($user->id);
        $ids      = $this->getFavoritesArray($profile->id);
        return (new AdsRepository)->getByCurrentProfileFavoritesAdsSortedDesc($ids);
    }

    /*
     * Получаем ид побъявлений из куки
     * @return Collection - $ads возвращает коллекию отложенных объявлений
     */
    public function favoritesListNotAuth()
    {
        $ids = json_decode(Cookie::get('favorites'));
        if($ids) $response = (new AdsRepository)->getByCurrentProfileFavoritesAdsSortedDesc($ids);
        else $response = '';
        return $response;
    }

    public function getFavoritesIds(){
        if (Auth::check()) {
           $profileRepository = new ProfileRepository();
           $profile           = $profileRepository->getFirstProfileByUser(Auth::id());
           $adsIds = $profileRepository->getFavoritesArray($profile->id);
        }else{
           $adsIds =  json_decode(Cookie::get('favorites'));
        }
        return $adsIds;
    }
    /*
    * @param model $user
    * @return Array
    * Получаем связанного пользователя
    */
    public function getFavoritesArray($id)
    {
        return DB::table('favorites')
            ->select(array('article_id'))
            ->where('profile_id', $id)
            ->pluck('article_id')->toArray();

    }
    /*
    * @param ind user id $id
    * @return Collection
    * Передаём id пользователя и
    * возвращаем коллекцию со связами
    */
    public function getFavoritesWithPagination($ids, $per = 9)
    {
        return (new AdsRepository)->getByCurrentProfileFavoritesAdsSortedDesc($ids);
    }


    public function setProfileNameAfterRegister($id)
    {
        $profile = $this->getFirstProfileByUser($id)->update(['name' => 'Пользователь_' . $id]);
    }

    /*
    * @return string
    */
    protected function getModelClass()
    {
        return Model::class;
    }

    /*
    * @param int $id
    * @return Model
    * Получаем связанный профиль
    */
    public function getEdit($id)
    {
        return $this->startCondition()->find($id);
    }


    /*
    * @param int $id
    * @return String
    * Получаем имя профиля пользователя
    */
    public function getProfileNameByUserId($id)
    {
        $profile = $this->getFirstProfileByUser($id);
        return  $profile ?  $profile->name : null;

    }

    /*
    * @param Model $profile
    * @return String
    * Возвращает аватарку пользователя
    */
    public function getProfileImg($profile)
    {
        //dd($profile);
        if (Storage::exists($profile->image)) {
            return (Storage::url($profile->image));
        } else {
            return Storage::url('/images/defaults/cake.svg');
        }
    }

    /*
    * @param id|Model
    * @return Bool
    * Получаем статус профиля для разрищения
    */
    public function checkIsFilled($profile, $user = null)
    {
        if ($profile->address && $profile->contact1 && $profile->name) {
            return true;
        } else {
            return false;
        }
    }

    /*
    * @param model $user
    * @return Model
    * Получаем связанный профиль
    */
    public function getUserProfileEdit($user)
    {
        return $this->startCondition()->find($user)->profiles;
    }

    /*
    * @param Ind|Model $id или модель Пользовтеля
    * @return Model
    * Получаем связанный профиль
    */
    public function getFirstProfileByUser($user)
    {
        if(!is_object($user)) {
            $user = \DB::table('users')->find($user);
        }

        $profile = $this->startCondition()->where('user_id', $user->id)->first();
        return $profile;
    }

    /*
    * @param int $id
    * @return Bool
    * Проверчем есть ли id поста в избранном
    */
    public function checkIfFavoritesIsSet($id, $userId)
    {
        $profileId =  $this->getFirstProfileByUser($userId)->id;
        $res = DB::table('favorites')
            ->where('article_id', $id)
            ->where('profile_id', $profileId)
            ->first();

        return !!$res;
    }

    /*
    * @param model $user
    * @return Model
    * Получаем связанного пользователя
    */
    public function getUserEdit($user)
    {
        return $this->startCondition()->user;
    }

    public function getTypes()
    {
        return $this->startCondition()->types;
    }

    /*
    * @param model User
    * @return bool
    * Проверяем заполнение минимальных требований
    * к профилю для допуска к странице объявлений
    */
    public function checkIfCanAddAds($user)
    {
        return $this->startCondition()->where('user_id', $user->id)->first()->filled;
    }




//    /*
//    * @return Model\Illuminate\Foundation\Application|mixed
//    */
//       protected function startCondition(){
//        return clone $this->model;
//    }
}
