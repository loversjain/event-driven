<?php

namespace App\Notifications;

use App\Enums\EventType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class UserNotified extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $message;
    protected $metaData;

    public function __construct(   $metaData, $message){
        $this->metaData = $metaData;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Notification(1) from Event Driven App.')
            ->line("Hello " . $this->metaData['name']. ',')
            ->line($this->message);
                    
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
