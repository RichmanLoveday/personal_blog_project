<?php

use App\Jobs\SendAdvertDeactivationNotification;
use App\Jobs\SendAdvertExpiringNotification;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

//? scheduled job for sending advert expiring notification
Schedule::job(new SendAdvertExpiringNotification)
    ->daily()
    ->everySixHours();

//? scheduled job for sending advert deactivation notification
Schedule::job(new SendAdvertDeactivationNotification)
    ->daily()
    ->everySixHours();
