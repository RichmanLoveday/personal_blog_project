<?php

namespace App\Notifications;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewArticlePublished extends Notification
{
    use Queueable;

    protected $article;
    protected $subscriber_token;
    protected $senderModel;

    /**
     * Create a new notification instance.
     */
    public function __construct($article, $subscriber_token, $senderModel = null)
    {
        $this->senderModel = $senderModel;
        $this->subscriber_token = $subscriber_token;
        $this->article = $article;
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
        $settings = Setting::first();
        // echo url(route('blog.show', $this->article->id));
        // echo url(route('unsubscribe', $notifiable->id));
        // die;
        return (new MailMessage)
            ->from($this->senderModel->email, $this->senderModel->firstName . ' ' . $this->senderModel->lastName)
            ->subject('New Article Published: ' . $this->article->title)
            ->view('emails.new_article_published', [
                'articleImage' => $this->article->image,
                'articleTitle' => $this->article->title,
                'articleSummary' => $this->article->text,
                'facebookLink' => $settings->facebook_link,
                'twitterLink' => $settings->twitter_link,
                'articleUrl' => url((route('blog.show', $this->article->slug . '-' . $this->article->id))),
                'unsubscribeLink' => url(route(
                    'unsubscribe',
                    ['token' => $this->subscriber_token]
                )),
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