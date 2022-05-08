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

    const SUCCESS_TEXT= "Ваше объявление  было одобрено модераторами, теперь его могут видеть все пользователи, не забывайте обновлять его для более эффективной выдачи на страницах нашего проекта.";
    const FAILED_TEXT = "К сожалению Ваше объявление не прошло модерацию, со списком требований к размещаемому объявлению можете ознакомиться перейдя по ссылке.";

    /**
     * Create a new notification instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;

        if($data["moderate"]){
            $this->data['text'] = self::SUCCESS_TEXT;
            $this->data['subject'] = "Модерация объявления [успех]";
            $this->data['link'] =  route('profile.ads.index');
            $this->data['link_text'] =  'Мои объявления';
        }
        else{
            $this->data['text'] = self::FAILED_TEXT;
            $this->data['subject'] = "Модерация объявления[отказ]";
            $this->data['link'] = route('profile.moderate.index');
            $this->data['link_text'] = 'Прочить уведомление';
        }


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
                    ->action($data['link_text'], $data['link']);
    }


    public function prepare(){
        return [
            'title' => $this->data['subject'],
            'ads_title' => $this->data['title'],
            'link'  => $this->data["link"],
            'text' => $this->data['text'],
            'link_text' => $this->data['link_text']
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
