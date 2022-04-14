<?php

namespace App\Repositories;


use App\Models\Article;
use App\Models\Comment;
use App\Repositories\CoreRepository;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Comment as Model;

use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\Models\Media;
use App\Models\Profile;
use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Eloquent\Builder;
use Throwable;

class CommentsRepository extends CoreRepository
{


    /*
    * @return string
    */
    public function getTodayComments ($count = 10) {
        $records = Model::whereDate('created_at', Carbon::today())->take($count)->get();
        if($records->isEmpty()) return 0;
        return $records;
    }

    /**
     * @param $room_id
     * @return array
     * Возвращаем компанты со связями
     * Профилем владельца
     * Профилем отправителя
     * Объявлением
     */
    public function getRoomWithRelations($room_id){
       return Room::with(['adsOwner.profiles', 'adsAsked.profiles', 'ads'])
            ->where('id', $room_id)
            ->first()
            ->toArray();
    }

    /**
     * @param $room_id
     * @param $field
     */
    public function murkAsRead($room_id, $field){
        $comment = tap(\DB::table('comments')
            ->where('comments.room', $room_id))
            ->update([$field => Carbon::now()]);
    }


    /**
     * @param $userId
     * @param $field
     * @return  $count
     */
    public function notReadQuestions($userId){
        try {
            return \DB::table('comments')
                      ->select('comments.id')
                      ->leftJoin('rooms', 'rooms.id', '=', 'comments.room')
                      ->where('rooms.owner_id', $userId)
                      ->whereNull("comments.recipient_read_at")
                      ->count();
        }catch (\Exception $e){
            return 0;
        }
    }


    /**
     * @param $userId
     * @param $field
     * @return  $count
     */
    public function notReadAnswers($userId){
        try {
            return \DB::table('comments')
                      ->select('comments.id')
                      ->leftJoin('rooms', 'rooms.id', '=', 'comments.room')
                      ->where('rooms.asked_id', $userId)
                      ->whereNull("comments.sender_read_at")->count();
        }catch (\Exception $e){
            return 0;
        }

    }


    /**
     * Todo:
     * @todo Проверить есть ли комнаты где владелец текущий пользователь
     * @todo Если есть то сгруппировать по поста
     * @todo Если есть то сгруппировать по поста
     * @todo Вернуть поля:
     *      имя пользователя;
     *      название поста;
     *      количество комментарием;
     *      колличество не прочитанных комментарием
     *
     */

    public function toMeComments () {
        $rooms = \DB::table('comments')
                    ->select(\DB::raw('COUNT(comments.comment) AS count'), 'articles.id')
                    ->selectRaw('ANY_VALUE(rooms.id) as room_id')
                    ->selectRaw('ANY_VALUE(rooms.comment_id) as parent_comment_id')
                    ->selectRaw('ANY_VALUE(rooms.asked_id) as asked_id')
                    ->selectRaw('ANY_VALUE(profiles.name) as name')
                    ->selectRaw('ANY_VALUE(articles.title) as title')
                    ->selectRaw('ANY_VALUE(articles.id) as article_id')
                    ->selectRaw('ANY_VALUE(media.id) as media_id')
                    ->selectRaw('max(comments.updated_at) AS last_date')
                    ->selectRaw('ANY_VALUE(media.file_name) as file_name')
                    ->join('rooms', 'comments.room', '=', 'rooms.id')
                    ->leftJoin('media', 'media.model_id', '=', 'comments.article_id')
                    ->join('profiles', 'profiles.user_id', '=', 'rooms.asked_id')
                    ->join('articles', 'articles.id', '=', 'rooms.article_id')
                    ->where('rooms.owner_id', Auth::id())
                    ->orderBy('last_date', 'desc')
                    ->groupBy('rooms.article_id', 'rooms.asked_id')
                    ->paginate(10);

        //Не прочитанные сообщения владельцу поста
        if ($rooms->isNotEmpty()) {
            $rooms->each(function ($item, $key) {
                $item->not_read = \DB::table('comments')
                                     ->select('comments.id')
                                     ->whereNull('comments.recipient_read_at')
                                     ->where('comments.room', $item->room_id)
                                     ->count();
            });
        }
        return $rooms->isNotEmpty() ? $rooms : [];
    }



    public function myComments () {

        $rooms = \DB::table('comments')
                    ->select(\DB::raw('COUNT(comments.comment) AS count'), 'articles.id')
                    ->selectRaw('ANY_VALUE(rooms.id) as room_id')
                    ->selectRaw('ANY_VALUE(rooms.comment_id) as parent_comment_id')
                    ->selectRaw('ANY_VALUE(rooms.owner_id) as owner_id')
                    ->selectRaw('ANY_VALUE(profiles.name) as name')
                    ->selectRaw('ANY_VALUE(articles.title) as title')
                    ->selectRaw('ANY_VALUE(articles.id) as article_id')
                    ->selectRaw('ANY_VALUE(media.id) as media_id')
                    ->selectRaw('max(comments.updated_at) AS last_date')
                    ->selectRaw('ANY_VALUE(media.file_name) as file_name')
                    ->join('rooms', 'comments.room', '=', 'rooms.id')
                    ->leftJoin('media', 'media.model_id', '=', 'comments.article_id')
                    ->join('profiles', 'profiles.user_id', '=', 'rooms.owner_id')
                    ->join('articles', 'articles.id', '=', 'rooms.article_id')
                    ->where('rooms.asked_id', Auth::id())
                    ->orderBy('last_date', 'desc')
                    ->groupBy('rooms.article_id', 'rooms.owner_id')
                    ->paginate(10);

        if ($rooms->isNotEmpty()) {
            //Не прочитанные сообщения владельцу поста
            if ($rooms->isNotEmpty()) {
                $rooms->each(function ($item, $key) {
                    $item->not_read = \DB::table('comments')
                                         ->select('comments.id')
                                         ->whereNull('comments.sender_read_at')
                                         ->where('comments.room', $item->room_id)
                                         ->count();
                });
            }


        }
        return $rooms->isNotEmpty() ? $rooms : [];
    }


    /**
     *
     * @param $user_from int
     * @param $article_id int
     * @return Comment
     */
    public function getToUserFirstBranchId ($user_from, $article_id) {
        return \DB::table('comments')
                  ->select('id')
                  ->where('comments.article_id', $article_id)
                  ->where('comments.from_user_id', $user_from)
                  ->where('comments.parent_id', 0)
                  ->first();
    }

    /**
     * Возвращаем количество комментарием от пользователя по id
     * @param $user_from
     * @param $article_id
     * @return int
     */
    public function getToUserCommentsCount ($user_from, $article_id) {
        return \DB::table('comments')
                  ->select('id')
                  ->where('comments.article_id', $article_id)
                  ->where('comments.from_user_id', $user_from)
                  ->count();
    }



    /**
     **  Создание нового комментария с фронта
     * @param array $request - Объект запроса
     * @return array - возвращает лтбо новый комментарий либо массив с ошибкой
     * @throws \Exception
     */
    public function create ($request) {
        try {

            // Получаем id автора
            $adsAuthor = \DB::table('articles')
                            ->select('user_id')
                            ->where('id', $request['article_id'])
                            ->first();

            // Определяем владельца
            $commentOwner = helper_comment_owner_asked($adsAuthor->user_id, $request['user_id'], $request['from_user_id']);

            // Проверяем есть ли комната если нет, то подготавливаем модель
            $room = Room::firstOrNew([
                'article_id' => $request['article_id'],
                'owner_id' => $commentOwner['owner'],
                'asked_id' => $commentOwner['asking'],
            ]);

            // Подготавливаем модел комментария
            $newComment = new Comment([
                'from_user_id' => $request['from_user_id'],
                'parent_id' => ($room->comment_id) ?? 0,
                'sender_read_at' => Carbon::now(),
                'user_id' => $request['user_id'],
                'article_id' => $request['article_id'],
                'comment' => $request['question'],
            ]);

            // если комната есть, добавляем в комментария и сохраняем
            // или сохраняем подготовлиную комнату и записывем ид в комментарий
            if ($room->id) {
                $newComment['room'] = $room->id;
                $newComment['parent_id'] = $room->comment_id;
                $newComment->save();
            } else {
                $room->save();
                $newComment['room'] = $room->id;
                $newComment['parent_id'] = 0;
                $newComment->save();
                $room->update([
                    'comment_id' => $newComment->id,
                ]);
            }




            return ['comment' => $newComment, 'code' => 200];
        } catch (Throwable $e) {
            throw new \Exception($e->getMessage());
        }
    }




    function fail ($msg = 'Ошибка сохранения файла') {
        throw new \Exception($msg);
    }



    protected function getModelClass () {
        return Model::class;
    }
}
