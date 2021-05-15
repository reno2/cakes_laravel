<?php

namespace App\Notifications;

use App\Repositories\ProfileRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Article;

class CommentNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private $data;

    /**
     * Create a new notification instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Создан новый пост')
            ->line('Был создан новый материал с названием .' . $this->data['name']);
    }

    public function prepareData(){

        $advert =  Article::find($this->data->article_id);
        $fromUserName = (new ProfileRepository)->getProfileNameByUserId($this->data->from_user_id);
        return [
            'advert' => $advert->title,
            'url' => $advert->slug,
            'from_user_name' => $fromUserName,
            'comment' => $this->data->comment,
            'all' => $this->data
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
       return $this->prepareData();
    }
}
