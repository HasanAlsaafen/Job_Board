<?php

namespace App\Providers;

use App\Events\ApplicationStatusChanged;
use App\Listeners\SendApplicationStatusNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ApplicationStatusChanged::class => [
            SendApplicationStatusNotification::class,

        ],
    ];
}
