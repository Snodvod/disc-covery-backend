<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

use NotificationChannels\IonicPushNotifications\IonicPushChannel;
use NotificationChannels\IonicPushNotifications\IonicPushMessage;

class facebookPush extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [IonicPushChannel::class];
    }

    public function toIonicPush($notifiable)
    {
        return IonicPushMessage::create('push_profile')
            ->title('Send')
            ->message('nudes')
            ->sound('ping.aiff')
            ->payload(['foo' => 'bar']);
    }
}
