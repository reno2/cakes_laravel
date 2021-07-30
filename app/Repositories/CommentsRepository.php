<?php

namespace App\Repositories;


use App\Models\Article;
use App\Models\Comment;
use App\Repositories\CoreRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Article as Model;

use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\Models\Media;
use App\Models\Profile;
use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Eloquent\Builder;

class CommentsRepository extends CoreRepository
{

    public function getQuestionsToAuthor (User $user) {
        return \DB::table('comments')
                  ->join('articles', 'articles.id', '=', 'comments.article_id')
                  ->join('profiles', 'profiles.user_id', '=', 'comments.from_user_id')
                  ->leftJoin('media', 'media.model_id', '=', 'comments.article_id')
                  ->select(\DB::raw('COUNT(comments.comment) AS count'))
                  ->selectRaw('ANY_VALUE(comments.user_id) as user_id')
                  ->selectRaw('ANY_VALUE(comments.from_user_id) as from_user_id')
                  ->selectRaw('ANY_VALUE(comments.article_id) as article_id')
                  ->selectRaw('ANY_VALUE(profiles.name) as name')
                  ->selectRaw('ANY_VALUE(articles.title) as title')
                  ->selectRaw('MAX(comments.created_at) AS last_date')
                  ->selectRaw('ANY_VALUE(media.file_name) as file_name')
                  ->selectRaw('ANY_VALUE(media.id) as media_id')
                  ->where('comments.user_id', $user->id)
                  ->groupBy('comments.article_id', 'comments.from_user_id')
                  ->orderBy('last_date', 'DESC')
                  ->get();
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
                    ->selectRaw('ANY_VALUE(rooms.updated_at) AS last_date')
                    ->selectRaw('ANY_VALUE(media.file_name) as file_name')
                    ->join('rooms', 'comments.room', '=', 'rooms.id')
                    ->leftJoin('media', 'media.model_id', '=', 'comments.article_id')
                    ->join('profiles', 'profiles.user_id', '=', 'rooms.asked_id')
                    ->join('articles', 'articles.id', '=', 'rooms.article_id')
                    ->where('rooms.owner_id', Auth::id())
                    ->orderBy('last_date', 'desc')
                    ->groupBy('rooms.article_id', 'rooms.asked_id')
                    ->paginate(10);

        if ($rooms->isNotEmpty()) {
            //Не прочитанные сообщения владельцу поста
            $notRead = array ();
            array_map(function ($item) use (&$notRead) {
                $notRead["{$item->id}_{$item->asked_id}"] = (Array)$item; // object to array
            }, \DB::table('comments')
                  ->select(\DB::raw('COUNT(comments.id) AS not_read'), 'articles.id as id')
                  ->selectRaw('ANY_VALUE(rooms.asked_id) AS asked_id')
                  ->selectRaw('ANY_VALUE(articles.id) AS article_id')
                  ->join('rooms', 'comments.room', '=', 'rooms.id')
                  ->join('articles', 'articles.id', 'rooms.article_id')
                  ->where('rooms.owner_id', Auth::id())
                  ->whereNull('comments.recipient_read_at')
                  ->groupBy('rooms.asked_id', 'rooms.article_id')
                  ->get()->toArray()
            );

            if (count($notRead)) {
                $rooms->each(function ($item, $key) use ($notRead) {
                    $item->not_read = (array_key_exists("{$item->id}_{$item->asked_id}", $notRead)) ?
                        $notRead["{$item->id}_{$item->asked_id}"]["not_read"] : NULL;
                });
            }
        }
        return $rooms->isNotEmpty() ? $rooms : NULL;
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
                    ->selectRaw('ANY_VALUE(rooms.updated_at) AS last_date')
                    ->selectRaw('ANY_VALUE(media.file_name) as file_name')
                    ->join('rooms', 'comments.room', '=', 'rooms.id')
                    ->leftJoin('media', 'media.model_id', '=', 'comments.article_id')
                    ->join('profiles', 'profiles.user_id', '=', 'rooms.owner_id')
                    ->join('articles', 'articles.id', '=', 'rooms.article_id')
                    ->where('rooms.asked_id', Auth::id())
                    ->orderBy('last_date', 'desc')
                    ->groupBy('rooms.article_id', 'rooms.owner_id')
                   // ->get();
                    ->paginate(10);

        if ($rooms->isNotEmpty()) {
            //Не прочитанные сообщения владельцу поста
            $notRead = array ();
            array_map(function ($item) use (&$notRead) {
                $notRead["{$item->id}_{$item->owner_id}"] = (Array)$item; // object to array
            }, \DB::table('comments')
                  ->select(\DB::raw('COUNT(comments.id) AS not_read'), 'articles.id as id')
                  ->selectRaw('ANY_VALUE(rooms.owner_id) AS owner_id')
                  ->selectRaw('ANY_VALUE(articles.id) AS article_id')
                  ->join('rooms', 'comments.room', '=', 'rooms.id')
                  ->join('articles', 'articles.id', 'rooms.article_id')
                  ->where('rooms.owner_id', Auth::id())
                  ->whereNull('comments.sender_read_at')
                  ->groupBy('rooms.asked_id', 'rooms.article_id')
                  ->get()->toArray()
            );

            if (count($notRead)) {
                $rooms->each(function ($item, $key) use ($notRead) {
                    $item->not_read = (array_key_exists("{$item->id}_{$item->owner_id}", $notRead)) ?
                        $notRead["{$item->id}_{$item->owner_id}"]["not_read"] : NULL;
                });
            }
        }
        return $rooms->isNotEmpty() ? $rooms : NULL;
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




            //            $newComment = new Comment([
            //                'from_user_id' => $request['from_user_id'],
            //                'parent_id'    => ($room->comment_id) ??  0,
            //                'sender_read_at' => Carbon::now(),
            //                'user_id'      => $request['user_id'],
            //                'article_id'   => $request['article_id'],
            //                'comment'      => $request['question'],
            //            ]);
            //
            //
            //            if(!$room->id){
            //              $room = $room->save();
            //              $newComment->room = $room->id;
            //              $newComment = $newComment->save();
            //
            //            }
            //
            //            //$room->comment_id =
            //
            //            if(!$room){
            //                $room = Room::create([
            //                    'name' => 'some',
            //                    'owner_id' => $commentOwner['owner'],
            //                    'asked_id' => $commentOwner['asking']
            //                ]);
            //                $commentId = 0;
            //            }else{
            //                $commentId = $this->getToUserFirstBranchId($request['user_id'], $request['article_id']);
            //            }



            //$room = new Room(['name' => 'some', 'owner_id' => $commentOwner['owner'], 'asked_id' => $commentOwner['asking']]);
            //
            //            $comment = \DB::table('comments')
            //                ->where('comments.article_id', $request['article_id'])
            //                ->where('comments.from_user_id', $request['from_user_id'])
            //                ->select(\DB::raw('COUNT(comments.from_user_id) AS count'))
            //                ->selectRaw('MAX(comments.created_at) AS last_date')
            //                ->selectRaw('ANY_VALUE(comments.id) as id')
            //                ->selectRaw('ANY_VALUE(comments.room) as room')
            //                ->groupBy('comments.article_id')
            //                ->orderBy('last_date', 'DESC')
            //                ->first();
            //
            //            if(!$comment) {
            //                $commentId = 0;
            //
            //            }
            //            else $commentId = $comment->id;
            //
            //            $newComment = Comment::create([
            //                'from_user_id' => $request['from_user_id'],
            //                'parent_id'    => $commentId,
            //                'sender_read_at' => Carbon::now(),
            //                'user_id'      => $request['user_id'],
            //                'article_id'   => $request['article_id'],
            //                'comment'      => $request['question']
            //            ]);


            //
            //            if(!$comment){
            //                $adsAuthor = \DB::table('articles')->select('user_id')->where('id', $request['article_id'])->first();
            //                $commentOwner = helper_comment_owner_asked($adsAuthor->user_id, $request['user_id'], $request['from_user_id']);
            //                $room = new Room(['name' => 'some', 'owner_id' => $commentOwner['owner'], 'asked_id' => $commentOwner['asking']]);
            //                $newComment->rooms()->save($room);
            //                $newComment->update([
            //                    'room' =>$room->id
            //                ]);
            //
            //            }else{
            //
            //                $newComment->update([
            //                    'room' => $comment->room
            //                ]);
            //            }




            return ['comment' => $newComment, 'code' => 200];
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage(), 'code' => $e->getCode()];
        }
    }




    function fail ($msg = 'Ошибка сохранения файла') {
        throw new \Exception($msg);
    }

    /*
      * @return string
      */
    protected function getModelClass () {
        return Model::class;
    }
}
