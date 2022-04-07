<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ModerateNotification extends Notification implements ShouldQueue
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
       // $this->data = $data['rules'];
        $rr = '';
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $data = $this->prepare();
        return (new MailMessage)
                    ->subject($data['title'] )
                    ->line($data['text'])
                    ->action($data['ads_title'], $data['link']);
    }


    public function prepare(){
        $title = ($this->data["moderate"]) ? '[успех]' : '[отказ]';
        return [
            'title' => "Модерация объявления{$title}",
            'ads_title' => $this->data['title'],
            'link'  => $this->data["link"],
            'text' => "Ваше объявление {$this->data['title']} было одобрено модераторами портала, теперь его могут видеть все пользователи портала, не забывайте обновлять его для более эффективной выдачи на страницах портала."
        ];

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    public function toArray($notifiable)
    {
        return  $this->data;
    }
}
