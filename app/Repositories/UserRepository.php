<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User as Model;
use App\Repositories\CoreRepository;
use Illuminate\Support\Facades\Auth;

class UserRepository extends CoreRepository{
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
     * @param model $user
     * @return Model | int Id
     * Получаем связанный профиль
     */
    public function getUserProfileEdit($user){
        return $this->startCondition()->find($user)->profiles->first();
    }


//    /*
//    * @return Model\Illuminate\Foundation\Application|mixed
//    */
//       protected function startCondition(){
//        return clone $this->model;
//    }
}
