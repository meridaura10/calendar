<?php

namespace App\Providers;

use App\contracts\Calendar\CalendarContract;
use App\contracts\Notifications\Event\ReminderNotificationInterface;
use App\Services\Calendar\Calendar;
use App\Services\EventNotifications\EvenNotificationService;
use App\Services\EventNotifications\ReminderNotificationService;
use Illuminate\Support\ServiceProvider;

class CalendarServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CalendarContract::class, Calendar::class);

        $this->app->singleton(EvenNotificationService::class, EvenNotificationService::class);
        $this->app->singleton(ReminderNotificationInterface::class, ReminderNotificationService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
