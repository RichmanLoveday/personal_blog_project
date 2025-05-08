<?php

namespace App\Jobs;

use App\Models\Advert;
use App\Notifications\AdvertDeativationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAdvertDeactivationNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $updateType = 'admin';
    protected $advert = null;

    /**
     * Create a new job instance.
     */
    public function __construct($type = 'cron', ?Advert $advert = null)
    {
        $this->updateType = $type;
        $this->advert = $advert;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        if ($this->updateType == 'cron') {
            $this->cronJob();
        } else {
            $this->manualJob($this->advert);
        }
    }


    protected function cronJob()
    {
        //? get adverts that end date are less than today
        $adverts = Advert::where('end_date', '<', now()->toDateString())
            ->where('status', 'active')
            ->with(['user', 'placements'])
            ->get();

        if ($adverts->isEmpty()) return;

        //? change the status of the adverts to in-active
        foreach ($adverts as $advert) {
            $advert->update(['status' => 'in-active']);
            $advert->user->notify(new AdvertDeativationNotification($advert));
        }
    }


    public function manualJob(Advert $advert)
    {
        $advert->user->notify(new AdvertDeativationNotification($advert));
    }
}
