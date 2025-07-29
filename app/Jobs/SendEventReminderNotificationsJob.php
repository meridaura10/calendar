<?php

namespace App\Jobs;

use App\contracts\Notifications\Event\EvenNotificationInterface;
use App\contracts\Notifications\Event\ReminderNotificationInterface;
use App\Mail\EventEnded;
use App\Mail\EventStarted;
use App\Mail\ReminderStarted;
use App\Models\Event;
use App\Models\Reminder;
use App\Services\EventNotifications\EvenNotificationService;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEventReminderNotificationsJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected EvenNotificationInterface $evenNotification,
        protected ReminderNotificationInterface $reminderNotification,
    )
    {

    }

    public function handle(): void
    {
        $now = Carbon::now()->startOfMinute();

        $this->evenNotification->sendMessages($now);
        $this->reminderNotification->sendMessages($now);
    }
}
