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
        return ['mail', 'database'];
    }

    /**
     * Отправляем на почту
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->data['event_name'])
            ->line('Вопрос к посту .' . $this->data['title'])
            ->line('Ссылка .' . $this->data['url']);
    }

    /**
     * Записываем сообщение в базу
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
       return $this->data;
    }



    //    public function prepareData(){
    //        $advert =  Article::find($this->data->article_id);
    //        $fromUserName = (new ProfileRepository)->getProfileNameByUserId($this->data->from_user_id);
    //        return [
    //            'event_name' => 'Задан вопрос',
    //            'url' => '/ads/'.$advert->slug,
    //            'title' => $advert->title,
    //            'recipient' => $fromUserName,
    //            'message' => $this->data->comment,
    //        ];
    //    }
}
