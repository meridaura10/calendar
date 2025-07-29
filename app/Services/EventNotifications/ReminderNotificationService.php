<?php

namespace App\Services\EventNotifications;

use App\contracts\Notifications\Event\ReminderNotificationInterface;
use App\Mail\ReminderStarted;
use App\Models\Reminder;
use Carbon\Carbon;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Facades\Mail;

class ReminderNotificationService implements ReminderNotificationInterface
{
    public function __construct(
        protected ?string $mailStarting = null,
        protected ?string $telegramStarting = null,
    )
    {
        $this->mailStarting ??= ReminderStarted::class;

        $this->telegramStarting ??= 'Подія починається: ';
    }
    public function sendMessages(Carbon $now): void
    {
        $events = $this->getStartingRemindersToMinute($now);

        $this->sendMailStartingReminders($events);
        $this->sendTelegramStartingReminders($events);
    }

    public function sendTelegramStartingReminders(iterable $reminders): void
    {
        $this->sendTelegram($reminders, $this->telegramStarting);
    }

    public function sendTelegram(iterable $reminders, string $view): void
    {
          try {
            foreach ($reminders as $reminder) {
                if ($reminder->user && $tg = $reminder->user->telegram_id) {
                    $chat = TelegraphChat::query()->where('chat_id', $tg)->first();

                    $chat->message($view. $reminder->title)->send();
                }
            }
        }catch (\Throwable $throwable){
            Log::error('telegram send error reminder notitfication'. $throwable->getMessage());
        }
    }

    public function sendMails(iterable $reminders,string $mail): void
    {
        foreach ($reminders as $reminder) {
            if ($reminder->user && $reminder->user->email) {
                Mail::to($reminder->user->email)->queue(new $mail($reminder));
            }
        }
    }

    public function getStartingRemindersToMinute(Carbon $now): iterable
    {
        return Reminder::where('datetime', '<=', $now)
            ->with('user')
            ->get()
            ->filter(function (Reminder $reminder) use ($now) {
                $recurrence = $reminder->recurrence ? json_decode($reminder->recurrence) : null;
                $baseTime = Carbon::parse($reminder->datetime);

                if ($now->format('H:i') !== $baseTime->format('H:i')) {
                    return false;
                }

                if (!$recurrence || $recurrence->type === 'none') {
                    return $now->isSameDay($baseTime);
                }

                if ($recurrence->type === 'daily') {
                    return $now->greaterThanOrEqualTo($baseTime);
                }

                if ($recurrence->type === 'days') {
                    return in_array($now->dayOfWeek, (array) $recurrence->data)
                        && $now->greaterThanOrEqualTo($baseTime);
                }

                if ($recurrence->type === 'yearly') {
                    return $now->day == $recurrence->data->day
                        && $now->month == $recurrence->data->month
                        && $now->greaterThanOrEqualTo($baseTime);
                }

                return false;
            });
    }

    public function sendMailStartingReminders(iterable $reminders): void
    {
        $this->sendMails($reminders, $this->mailStarting);
    }
}
