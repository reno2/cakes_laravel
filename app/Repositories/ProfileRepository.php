<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Profile as Model;
use App\Repositories\CoreRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileRepository extends CoreRepository
{
//    /**
//     * determins if the user role is Admin
//     * @return bool
//     */
//    public function isAdmin(User $user)
//    {
//        return $user->role == self::ROLES['admin'];
//    }
//    /**
//     * determins if the user role is Author
//     * @return bool
//     */
//    public function isAuthor()
//    {
//        return Auth::user()->role == self::ROLES['author'];
//    }

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
        return $this->getFirstProfileByUser($id)->name;
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
    * @param Ind $id
    * @return Model
    * Получаем связанный профиль
    */
    public function getFirstProfileByUser($id)
    {
        return $this->startCondition()->where('user_id', $id)->first();
    }

    /*
    * @param int $id
    * @return Bool
    * Проверчем есть ли id поста в избранном
    */
    public function checkIfFavoritesIsSet($id)
    {
        $res = DB::table('favorites')
            ->where('article_id', $id)
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

    /*
    * @param model $user
    * @return Arra
    * Получаем связанного пользователя
    */
    public function getFavoritesArray($id)
    {
        return  DB::table('favorites')
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
    public function getFavoritesWithPagination($id, $per = 9 )
    {
       return (new AdsRepository)->getByCurrentProfileFavoritesAdsSortedDesc($id);
//        return DB::table('articles')->where('user_id', $id)->orderBy('created_at', 'desc')->paginate($per);
        //return  (new AdsRepository)->getByCurrentProfileAdsSortedDesc()

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
        $status = $this->startCondition()->find($user->id)->filled;
        $rr     = '';
//        if ($user instanceof \Illuminate\Database\Eloquent\Model) {
//            $status =  $user->filled;
//        }else {
//            $status =  $this->startCondition()->find($user)->filled;
//        }

        return $status;
    }




//    /*
//    * @return Model\Illuminate\Foundation\Application|mixed
//    */
//       protected function startCondition(){
//        return clone $this->model;
//    }
}
