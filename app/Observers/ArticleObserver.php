<?php

namespace App\Observers;

use App\Models\Article;
use App\Models\User;
use App\Notifications\PostCreatedNotification;
use Illuminate\Support\Facades\Notification;

class ArticleObserver
{
    /**
     * Handle the profile "created" event.
     *
     * @param Article $article
     *
     * @return void
     */
    public function created(Article $article)
    {

        $userTo = User::find(1);
        $data = [
            'name' => $article->title
        ];
        Notification::send($userTo, new PostCreatedNotification($data));
        //dd($userTo);
    }

    /**
     * Handle the post "saving" event.
     *
     * @param $article
     * @return void
     */
    public function saving(Article $article)
    {
        $article->title =  strip_tags($article->title);
    }


    /**
     * Handle the profile "updated" event.
     *
     * @param Article $article
     *
     * @return void
     */
    public function updated(Article $article)
    {
        //
    }

    /**
     * На событии обновления удаляем все html теги
     *
     * @param Article $article
     *
     * @return void
     */
    public function updating(Article $article)
    {
        $article->title = strip_tags($article->title);
        $article->description = strip_tags($article->description);

    }
    /**
     * Handle the profile "deleted" event.
     *
     * @param Article $article
     *
     * @return void
     */
    public function deleted(Article $article)
    {
        //
    }

    /**
     * Handle the profile "restored" event.
     *
     * @param Article $article
     *
     * @return void
     */
    public function restored(Article $article)
    {
        //
    }

    /**
     * Handle the profile "force deleted" event.
     *
     * @param $article $article
     *
     * @return void
     */
    public function forceDeleted(Article $article)
    {
        //
    }
}
