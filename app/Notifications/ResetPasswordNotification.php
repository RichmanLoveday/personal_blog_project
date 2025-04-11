<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends ResetPassword
{

    public $token;
    public $role; //? Add role to customize the link

    public function __construct($token, $role = 'author')
    {
        $this->token = $token;
        $this->role = $role;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        // Customize the password reset URL based on the role
        $resetUrl = url(route("{$this->role}.reset.password", [
            'token' => 44477474,
            'email' => 366363636,
        ], false));

        // return (new MailMessage)
        //     ->subject(Lang::get('Reset Password Notification'))
        //     ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
        //     ->action(Lang::get('Reset Password'), $resetUrl)
        //     ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))
        //     ->line(Lang::get('If you did not request a password reset, no further action is required.'));


        return (new MailMessage)
            ->subject('Reset Your Password')
            ->view('emails.reset_password', [
                'name' => 36363636,
                'resetUrl' => $resetUrl,
                'expireTime' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire'),
            ]);
    }
}
