<?php

namespace App\Observers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\CommentNotification;
use App\Repositories\CommentsRepository;
use App\Repositories\ProfileRepository;
use Illuminate\Support\Facades\Notification;

class CommentObserver
{
    /**
     * Отработает после добавления комментария
     *
     * @param Comment $comment
     * @return void
     */
    public function created(Comment $comment)
    {
        $userTo = User::find($comment->user_id);
        $ads =  Article::find($comment->article_id);
        $fromUserName = (new ProfileRepository)->getProfileNameByUserId($comment->user_id);
        $data = [
            'event_name' => 'Задан вопрос',
            //'url' => '/ads/'.$ads->slug,
            'url' => '/profile/comments/'.$comment->article_id .'/'. $comment->from_user_id,
            'title' => $ads->title,
            'recipient' => $fromUserName,
            'message' => $comment->comment
        ];
        Notification::send($userTo, new CommentNotification($data));
    }

    /**
     * Handle the comment "updated" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function updated(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "deleted" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function deleted(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "restored" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function restored(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "force deleted" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function forceDeleted(Comment $comment)
    {
        //
    }
}
