<?php

namespace App\Listeners;

use App\Events\ApplicationStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\ApplicationStatusChanged as StatusNotification;

class SendApplicationStatusNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ApplicationStatusChanged $event): void
    {
        $event->application->user->notify(new StatusNotification($event->application));
    }
}
