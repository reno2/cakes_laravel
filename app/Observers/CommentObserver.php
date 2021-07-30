<?php

namespace App\Observers;


use App\Events\CommentEvent;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Room;
use App\Models\User;
use App\Notifications\CommentNotification;
use App\Repositories\CommentsRepository;
use App\Repositories\ProfileRepository;
use http\Env\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class CommentObserver
{
    /**
     * Отработает после добавления комментария
     *
     * @param Comment $comment
     * @return void
     */
    public function created (Comment $comment) {
        $userTo = User::find($comment->user_id);

        $ads = Article::find($comment->article_id);

        // Получаем владельца
        $commentOwner = helper_comment_owner_asked($ads->user_id, $comment->user_id, $comment->from_user_id);
        // Проверяем есть ли вопросы от пользователя
        $userCommentsCount = (new CommentsRepository)->getToUserCommentsCount($commentOwner['asking'], $comment->article_id);


        // Проверяем существует ли комната
      //  $isRoomExists = Room::where('name', "{$comment->article_id}.{$commentOwner['owner']}.{$commentOwner['asking']}")->exists();




        // Есть есть только один вопрос и нет комноты
//        if ($userCommentsCount === 1 && !$isRoomExists) {
//            try {
//                // Создаём комнаты и обновляем комментарий
//                $room = Room::create([
//                    'name' => "{$comment->article_id}.{$commentOwner['owner']}.{$commentOwner['asking']}",
//                    'owner_id' => $commentOwner['owner'],
//                    'asked_id' => $commentOwner['asking'],
//                ]);
//                $comment->update(['room' => $room->name]);
//            } catch (\Throwable $e) {
//                Log::error('Комната чата не создана ' . $e->getMessage() . __FILE__);
//
//            }
//        } else {
//            $comment->update([
//                'room' => "{$comment->article_id}.{$commentOwner['owner']}.{$commentOwner['asking']}"
//            ]);
//        }


        $ads = Article::find($comment->article_id);
        $fromUserName = (new ProfileRepository)->getProfileNameByUserId($comment->user_id);
        $data = [
            'event_name' => 'Задан вопрос',
            'url' => '/profile/comments/' . $comment->article_id . '/' . $comment->from_user_id,
            'title' => $ads->title,
            'recipient' => $fromUserName,
            'message' => $comment->comment,
        ];
        // События
        broadcast(new CommentEvent($comment->toArray()));
        //Notification::send($userTo, new CommentNotification($data));
    }

    /**
     * Handle the comment "updated" event.
     *
     * @param Comment $comment
     * @return void
     */
    public function updated (Comment $comment) {

        // Если коммент редактируется
        if (request()->isMethod('PUT')) {
            $resData = array_merge(
                $comment->toArray(),
                ['event' => 'updated']
            );
            broadcast(new CommentEvent($resData));
        }

    }

    /**
     * Handle the comment "deleted" event.
     *
     * @param Comment $comment
     * @return void
     */
    public function deleted (Comment $comment) {
        // Если коммент удаляется
        $resData = array_merge(
            $comment->toArray(),
            ['event' => 'delete']
        );
        broadcast(new CommentEvent($resData));
    }

    /**
     * Handle the comment "restored" event.
     *
     * @param \App\Comment $comment
     * @return void
     */
    public function restored (Comment $comment) {
        //
    }

    /**
     * Handle the comment "force deleted" event.
     *
     * @param \App\Comment $comment
     * @return void
     */
    public function forceDeleted (Comment $comment) {
        //
    }
}
