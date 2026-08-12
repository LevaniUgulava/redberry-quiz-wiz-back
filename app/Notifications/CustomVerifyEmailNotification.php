<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct() {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = $this->verificationUrl($notifiable);

        return (new MailMessage)->subject('Verify Your Email Address')->view('emails.verification', [
            'name' => $notifiable->name,
            'url' => $url,
            'text' => "You're almost there! To complete your sign up,
        please verify your email address.",
        ]);
    }

    protected function verificationUrl(object $notifiable): string
    {
        $id = $notifiable->getKey();
        $hash = sha1($notifiable->getEmailForVerification());

        // create signed route to prevent modification and will be valid 2 hours
        $temporarySignedURL = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(120),
            ['id' => $id, 'hash' => $hash]
        );

        // parse to get query parameters (expire&signature)
        $urlParts = parse_url($temporarySignedURL);
        parse_str($urlParts['query'], $query);

        // $query is array

        return config('app.frontend_url')."/signin?id={$id}&hash={$hash}&".http_build_query($query);

    }
}
