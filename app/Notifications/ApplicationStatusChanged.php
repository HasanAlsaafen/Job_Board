<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;
use App\Models\Applications;

class ApplicationStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Applications $application) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', WebPushChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Update on Your Application Status')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Your Application status has been updated ' . "'" . $this->application->jobListing->title . "'")
            ->line('The new Status is ' . $this->application->status)
            ->action('View my applications ', route('seeker.applications'))
            ->line('Thank you for using our application!');
    }
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Your application status has been changed"' . $this->application->jobListing->title . '"',
            'status' => $this->application->status,
            'job_title' => $this->application->jobListing->title,
            'application_id' => $this->application->id,
            'url' => route('seeker.applications'),
        ];
    }
    public function toWebPush(object $notifiable, mixed $notification): WebPushMessage
    {
        return (new WebPushMessage)
            ->title(' Update on Your Application Status')
            ->body(' Your applicatin status has been changed  "' . $this->application->jobListing->title . '"')
            ->action('View Applications', route('seeker.applications'))
            ->data(['url' => route('seeker.applications')]);
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
