<?php

namespace App\Notifications;

use App\Models\Advert;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdvertExpiringNotification extends Notification
{
    use Queueable;

    protected Advert $advert;

    /**
     * Create a new notification instance.
     */
    public function __construct(Advert $advert)
    {
        $this->advert = $advert;
    }

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
        $adminEmail = config('mail.admin_email', 'lovedayrichman@yahoo.com');
        $advertUrl = url(route('admin.advert.edit', $this->advert->id));
        $advertTitle = $this->advert->title;
        $advertStartDate = $this->advert->start_date;
        $advertEndDate = $this->advert->end_date;

        return (new MailMessage)
            ->from($adminEmail, 'Admin')
            ->subject('Advert Expiring Soon: ' . $advertTitle)
            ->view('emails.advert_expiring', [
                'advertUrl' => $advertUrl,
                'advertTitle' => $advertTitle,
                'advertStartDate' => $advertStartDate,
                'advertEndDate' => $advertEndDate,
            ]);
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