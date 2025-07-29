<?php

namespace App\contracts\Notifications\Event;

use Illuminate\Support\Carbon;

interface EvenNotificationInterface
{
    public function sendMessages(Carbon $now): void;

    public function sendMailStartingEvents(iterable $events): void;

    public function sendMailEndingEvents(iterable $events): void;

    public function sendTelegramStartingEvents(iterable $events): void;

    public function sendTelegramEndingEvents(iterable $events): void;
}
