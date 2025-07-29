<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\Reminder;
use App\Policies\EventPolicy;
use App\Policies\ReminderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Event::class => EventPolicy::class,
        Reminder::class => ReminderPolicy::class,
    ];
}
