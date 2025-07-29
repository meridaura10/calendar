<?php

namespace App\Services\EventNotifications;

use App\contracts\Notifications\Event\EvenNotificationInterface;
use App\Mail\EventEnded;
use App\Mail\EventStarted;
use App\Models\Event;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class EvenNotificationService implements EvenNotificationInterface
{
    public function __construct(
        protected ?string $mailStarting = null,
        protected ?string $mailEnding = null,

        protected ?string $telegramStarting = null,
        protected ?string $telegramEnding = null,
    )
    {
        $this->mailStarting ??= EventStarted::class;
        $this->mailEnding ??= EventEnded::class;

        $this->telegramStarting ??= 'Подія починається: ';
        $this->telegramEnding ??= 'Подія завершується: ';
    }
    public function sendMessages(Carbon $now): void
    {
        $events_starting = $this->getStartingEventsToMinute($now);
        $events_ending = $this->getEndingEventsToMinute($now);

        $this->sendMailStartingEvents($events_starting);
        $this->sendMailEndingEvents($events_ending);

        $this->sendTelegramStartingEvents($events_starting);
        $this->sendTelegramEndingEvents($events_ending);
    }

    public function sendMails(iterable $events,string $mail): void
    {
        foreach ($events as $event) {
            if ($event->user && $event->user->email) {
                Mail::to($event->user->email)->queue(new $mail($event));
            }
        }
    }

    public function sendMailStartingEvents(iterable $events): void
    {
        $this->sendMails($events, $this->mailStarting);
    }

    public function sendMailEndingEvents(iterable $events): void
    {
        $this->sendMails($events, $this->mailEnding);
    }

    public function getStartingEventsToMinute(Carbon $now): iterable
    {
        return Event::whereBetween('start_datetime', [
            $now,
            $now->copy()->endOfMinute()
        ])->with('user')->get();
    }

    public function getEndingEventsToMinute(Carbon $now): iterable
    {
        return Event::whereBetween('end_datetime', [
            $now,
            $now->copy()->endOfMinute()
        ])->with('user')->get();
    }

    public function sendTelegramStartingEvents(iterable $events): void
    {
       $this->sendTelegram($events, $this->telegramStarting);
    }

    public function sendTelegramEndingEvents(iterable $events): void
    {
        $this->sendTelegram($events, $this->telegramEnding);
    }

    public function sendTelegram(iterable $events, string $view): void
    {
        try {
            foreach ($events as $event) {
                if ($event->user && $tg = $event->user->telegram_id) {
                    $chat = TelegraphChat::query()->where('chat_id', $tg)->first();

                    $chat->message($view. $event->title)->send();
                }
            }
        }catch (\Throwable $throwable){
            Log::error('error to send message telegram event notification'. $throwable->getMessage());
        }
    }
}
