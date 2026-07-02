<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class NewDirectMessage extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Message $message) {}

    public function via(object $notifiable): array
    {
        return ['database', WebPushChannel::class];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'New message from ' . $this->message->user->name,
            'body' => Str::limit($this->message->body, 50),
            'conversation_id' => $this->message->conversation_id,
            'sender_name' => $this->message->user->name,
            'url' => route('conversations.show', $this->message->conversation_id),
        ];
    }

    public function toWebPush(object $notifiable, mixed $notification): WebPushMessage
    {
        return (new WebPushMessage)
            ->title('New message from ' . $this->message->user->name)
            ->body(Str::limit($this->message->body, 80))
            ->action('Open conversation', route('conversations.show', $this->message->conversation_id))
            ->data(['url' => route('conversations.show', $this->message->conversation_id)]);
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
