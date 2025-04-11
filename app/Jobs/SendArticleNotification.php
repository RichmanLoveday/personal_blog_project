<?php

namespace App\Jobs;

use App\Models\Subscribers;
use App\Models\Article;
use App\Models\User;
use App\Notifications\NewArticlePublished;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendArticleNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $article;
    protected $sender;

    /**
     * Create a new job instance.
     *
     * @param Article $article
     */
    public function __construct(Article $article, User $sender)
    {
        $this->sender = $sender;
        $this->article = $article;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subscribers = Subscribers::all();

        foreach ($subscribers as $subscribe) {
            $subscribe->notify(new NewArticlePublished($this->article, $this->sender));
        }
    }
}
