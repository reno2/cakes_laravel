<?php

namespace App\Observers;

use App\Models\Article;
use App\Models\User;
use App\Notifications\PostCreatedNotification;
use App\Repositories\ProfileRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;

class ArticleObserver
{
    /**
     * Handle the profile "created" event.
     * Срабатывает после того как объявление создано
     *
     * @param Article $article
     *
     * @return void
     */
    public function created(Article $article)
    {
        // Отправляем уведомления пользователять о создании нового
        $userTo = User::where('is_admin', 1)->get();
        $data = [
            'event_name' => 'Создано новое объявление',
            'url' => '/admin/article/'. $article->id .'/edit',
            'title' => $article->title,
            'recipient' => (new ProfileRepository)->getProfileNameByUserId($article->user_id)
        ];
        Notification::send($userTo, new PostCreatedNotification($data));

    }

    /**
     * Handle the post "saving" event.
     *
     * @param $article
     * @return void
     */
    public function saving(Article $article)
    {
        Cache::forget('front_categories');
        Cache::forget('front_ads');
        Cache::forget("front_ad_detail_{$article->id}");
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

//        if($article->user_id == Auth::id() && !Auth::user()->is_admin) {
//        $article->moderate = 0;
    //}

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
