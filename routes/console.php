<?php

use App\Jobs\SendAdvertDeactivationNotification;
use App\Jobs\SendAdvertExpiringNotification;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


//? adever scheduling for expiring and deactivation
Schedule::daily()
    ->everySixHours()
    ->group(function () {
        //? scheduled job for sending advert expiring notification
        Schedule::job(new SendAdvertExpiringNotification, 'advert-expiring')
            ->onSuccess(function () {
                $this->info('Advert expiring notification sent successfully.');
            })
            ->onFailure(function () {
                $this->error('Failed to send advert expiring notification.');
            });

        //? scheduled job for sending advert deactivation notification
        Schedule::job(new SendAdvertDeactivationNotification, 'advert-deactivation')
            ->onSuccess(function () {
                $this->info('Advert deactivation notification sent successfully.');
            })
            ->onFailure(function () {
                $this->error('Failed to send advert deactivation notification.');
            });
    });