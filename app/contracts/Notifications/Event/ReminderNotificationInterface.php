<?php

namespace App\contracts\Notifications\Event;

use Illuminate\Support\Carbon;

interface ReminderNotificationInterface
{
    public function sendMessages(Carbon $now): void;

    public function sendTelegramStartingReminders(iterable $reminders): void;

    public function sendMailStartingReminders(iterable $reminders): void;
}
