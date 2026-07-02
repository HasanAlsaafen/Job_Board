<?php

namespace App\Observers;

use App\Events\NotificationSent;
use Illuminate\Notifications\DatabaseNotification;

class DatabaseNotificationObserver
{
    public function created(DatabaseNotification $notification): void
    {
        broadcast(new NotificationSent(
            userId: $notification->notifiable_id,
            message: $notification->data['message'] ?? '',
            url: $notification->data['url'] ?? '/',
        ));
    }
}
