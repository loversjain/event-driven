<?php

namespace App\Listeners;

use App\Events\UserEvent;
use App\Enums\EventType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;
use App\Models\User;
use App\Notifications\UserNotified;
class UserListner implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     */
    public function handle(UserEvent $event): void
    {
        $user = User::find($event->userId);
       
        if(!empty($user)) {
            $message = $this->getMessage($event->eventType);
            $user->notify(new UserNotified($event->metaData,$message));
           

        }

    }

    protected function getMessage($eventType) {
        $message = match ($eventType) {
            EventType::SIGNUP->value => "Welcome" ,
            EventType::RENEWAL->value => "subscription renewal is pending. Please subscribe",
            EventType::PAYMENT_FAILURE->value => "Payment failure, Please retry after sometime",
            default => null
        };
        return $message;
    }
}
