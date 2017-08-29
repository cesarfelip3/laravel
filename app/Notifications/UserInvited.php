<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserInvited extends Notification
{
    use Queueable;

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $route = route('invitation', ['token' => $this->user->invitation_token]);
        $appName = config('app.name');

        return (new MailMessage)
            ->subject("You have being invited to be part of {$appName}!")
            ->greeting("Hello {$this->user->name}!")
            ->line("You are being invited to be part of {$appName}!")
            ->action('Accept invitation', $route)
            ->line('We hope you liked!');
    }

}
