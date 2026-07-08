<?php

namespace App\Livewire;

use Livewire\Component;

class PushSubscription extends Component
{
    public function saveSubscription(array $subscription): void
    {
        auth()->user()->updatePushSubscription(
            endpoint: $subscription['endpoint'],
            key: $subscription['keys']['p256dh'],
            token: $subscription['keys']['auth'],
            contentEncoding: 'aesgcm',
        );
    }
    public function render()
    {
        return view('livewire.push-subscription');
    }
}
