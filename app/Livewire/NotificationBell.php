<?php

namespace App\Livewire;

use Livewire\Component;


class NotificationBell extends Component
{
    public bool $isOpen = false;
    public function markAsRead(string $id): void
    {
        auth()->user()
            ->notifications()
            ->find($id)
            ?->markAsRead();
    }

    public function markAllAsRead(): void
    {
        auth()->user()->unreadNotifications->markAsRead();
    }

    public function getListeners(): array
    {
        return [
            "echo-private:notifications.{$this->getUserId()},NotificationSent" => 'refresh',
        ];
    }

    private function getUserId(): int
    {
        return auth()->id();
    }

    public function refresh(): void {}
    public function render()
    {
        return view('livewire.notification-bell', [
            'notifications' => auth()->user()
                ->notifications()
                ->latest()
                ->take(10)
                ->get(),
            'unreadCount' => auth()->user()->unreadNotifications->count(),
        ]);
    }
}
