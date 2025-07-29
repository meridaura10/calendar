<?php

use App\contracts\Notifications\Event\ReminderNotificationInterface;
use App\Services\EventNotifications\EvenNotificationService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:send-event-reminder-notifications', function () {
    dispatch(new \App\Jobs\SendEventReminderNotificationsJob(
        app(EvenNotificationService::class),
        app(ReminderNotificationInterface::class),
    ));
})->everyMinute();
