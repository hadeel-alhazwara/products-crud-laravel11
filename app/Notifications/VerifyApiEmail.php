<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class VerifyApiEmail extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',       
            Carbon::now()->addMinutes(60),
            ['id' => $notifiable->id, 'hash' => sha1($notifiable->email)]
        );

        return (new MailMessage)
            ->subject('تفعيل البريد الإلكتروني')
            ->line('اضغطي على الرابط لتفعيل حسابك:')
            ->action('تفعيل الحساب', $verificationUrl)
            ->line('إذا لم تطلبي هذا، تجاهلي الرسالة.');
    }
}
