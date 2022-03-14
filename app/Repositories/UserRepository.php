<?php

namespace App\Repositories;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User as Model;
use App\Repositories\CoreRepository;
use Illuminate\Support\Facades\Auth;

class UserRepository extends CoreRepository{


    public function getSortedPagination($repPare = 10){
        return $this->startCondition()->with('profiles')->orderBy('id', 'desc')->paginate($repPare);
    }




    public function getTodayUsers($count = 10){
        $records = Model::whereDate('created_at', Carbon::today())->take($count)->get();
        if($records->isEmpty()) return 0;
        return $records;
    }

    /**
     *  return null | $notice
     *  Не прочинаттые уведомления о модерации
     *  или null
     */
    public function getNotReadModerateNotice(){
        return $notices = Auth::user()->notifications()
                                ->where('type', 'App\Notifications\ModerateNotification')
                                ->whereNull('read_at')
                                ->simplePaginate(15) ?? '';
    }


    /**
     *  return null | $notice
     *  Количество не прочинаттые уведомления о модерации
     *  или null
     */
    public function getNotReadModerateNoticeCount(){
        return  Auth::user()->notifications()
                                ->where('type', 'App\Notifications\ModerateNotification')
                                ->whereNull('read_at')
                                ->get()->count() ?? 0;
    }



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
