<?php

namespace App\Jobs;

use App\Models\Advert;
use App\Notifications\AdvertExpiringNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAdvertExpiringNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        info('Reached here to inplement advert expiring notification.');

        //? contuct 3 days date to remind admin to renew advertisment
        $dates = [
            now()->addDays(2)->toDateString(),
            now()->addDays(2)->toDateString(),
            now()->addDays(1)->toDateString(),
        ];


        //? get all adverts that are expiring in 3 days
        $adverts = Advert::whereIn('end_date', $dates)
            ->where('status', 'active')
            ->with(['user', 'placements'])
            ->get();

        info('Adverts expiring notification sent successfully, will be expiring on ' . $adverts->pluck('end_date'));

        if ($adverts->isEmpty()) return;  //? if no adverts found, return

        //? loop through the adverts and send notification to admin
        foreach ($adverts as $advert) {
            info('Advert expiring notification sent successfully, will be expiring on ' . $advert->end_date);
            $advert->user->notify(new AdvertExpiringNotification($advert));
        }
    }
}
