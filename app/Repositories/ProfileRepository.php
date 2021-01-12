<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Profile as Model;
use App\Repositories\CoreRepository;
use Illuminate\Support\Facades\Auth;

class ProfileRepository extends CoreRepository{
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
    protected function getModelClass(){
        return Model::class;
    }

    /*
     * @param int $id
     * @return Model
     * Получаем связанный профиль
     */
    public function getEdit($id){
        return $this->startCondition()->find($id);
    }

    /*
    * @param id|Model
    * @return Bool
    * Получаем статус профиля для разрищения
    */
    public function checkIsFilled($profile, $user = null){
        if($profile->address && $profile->contact1 && $profile->name) return true;
        else return false;
    }

    /*
     * @param model $user
     * @return Model
     * Получаем связанный профиль
     */
    public function getUserProfileEdit($user){
        return $this->startCondition()->find($user)->profiles;
    }

    /*
  * @param model $user
  * @return Model
  * Получаем связанного пользователя
  */
    public function getUserEdit($user){
        return $this->startCondition()->user;
    }

    public function getTypes(){
        return $this->startCondition()->types;
    }


    /*
     * @param mixed $user|$id
     * @return bool
     * Проверяет заполнен ли профиль
     * и доступен для простотра закрытых страниц
     */

    public function checkIsFill($user){

        return $this->startCondition()->types;
    }

//    /*
//    * @return Model\Illuminate\Foundation\Application|mixed
//    */
//       protected function startCondition(){
//        return clone $this->model;
//    }
}
