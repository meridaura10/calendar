<?php

namespace App\Services\Calendar;

use App\contracts\Calendar\CalendarContract;
use App\Models\Event;
use App\Models\Reminder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Calendar implements CalendarContract
{
    protected CalendarData $data;

    public function __construct()
    {
        Carbon::setLocale('uk');

        $this->data = CalendarData::make()
            ->startOfWeek(Carbon::now()->startOfWeek())
            ->monthRange(Carbon::now()->startOfWeek(), Carbon::now()->startOfWeek()->addDays(35));
    }

    public function rows(int $year, int $month): array
    {
        $startOfMonth = Carbon::create($year, $month, 1);
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        $start = $startOfMonth->copy()->startOfWeek(Carbon::MONDAY);
        $end = $endOfMonth->copy()->endOfWeek(Carbon::SUNDAY);

        $current = $start->copy();
        $allDays = [];

        while ($current->lte($end)) {
            $allDays[] = [
                'date' => $current->toDateString(),
                'is_current_month' => $current->month === $startOfMonth->month,
                'reminders' => [],
                'events' => [],
                'count' => 0,
            ];
            $current->addDay();
        }

        $weeks = array_chunk($allDays, 7);

        $events = Auth::user()?->events()
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_datetime', [$start->copy()->startOfDay(), $end->copy()->endOfDay()])
                    ->orWhereBetween('end_datetime', [$start->copy()->startOfDay(), $end->copy()->endOfDay()]);
            })
            ->get();

        $reminders = Auth::user()?->reminders()
            ->where('datetime', '<=', $end->copy()->endOfDay())
            ->get();

        foreach ($weeks as $weekIndex => $week) {
            $weeks[$weekIndex] = [
                'days' => $week,
                'events' => [],
                'reminders' => [],
            ];
        }


        foreach ($events as $event) {
            $eventStart = Carbon::parse($event->start_datetime)->startOfDay();
            $eventEnd = Carbon::parse($event->end_datetime ?? $event->start_datetime)->endOfDay();

            foreach ($weeks as $weekIndex => &$week) {
                $weekStart = Carbon::parse($week['days'][0]['date'])->startOfDay();
                $weekEnd = Carbon::parse(end($week['days'])['date'])->endOfDay();

                if ($eventEnd->lt($weekStart) || $eventStart->gt($weekEnd)) {
                    continue;
                }

                $left = null;
                $cell = 0;
                $top = 0;

                for ($i = 0; $i < 7; $i++) {
                    $day = Carbon::parse($week['days'][$i]['date']);
                    if ($day->betweenIncluded($eventStart, $eventEnd)) {
                        if ($left === null) {
                            $left = $i;
                        }

                        $top = $week['days'][$i]['count'];

                        $week['days'][$i]['count'] = $week['days'][$i]['count'] + 1;

                        $cell++;
                    }
                }

                if ($cell > 0 && $left !== null) {
                    $week['events'][] = [
                        'event' => $event,
                        'left' => $left,
                        'cell' => $cell,
                        'top' => $top,
                    ];
                }
            }
            unset($week);
        }

        $sameDayReminders = [];
        foreach ($reminders as $reminder) {
            $recurrence = $reminder->recurrence ? json_decode($reminder->recurrence) : null;
            $baseDate = Carbon::parse($reminder->datetime);

            foreach ($weeks as $weekIndex => &$week) {
                $top = 0;

                for ($i = 0; $i < 7; $i++) {
                    $day = Carbon::parse($week['days'][$i]['date']);

                    $match = false;

                    if (!$recurrence || $recurrence->type === 'none') {
                        $match = $day->isSameDay($baseDate);
                    } elseif ($recurrence->type === 'month') {

                        $match = $day->day == $recurrence->data;

                    } elseif ($recurrence->type === 'daily') {
                        $match = true;
                    } elseif ($recurrence->type === 'days' && isset($recurrence->data)) {
                        $match = in_array($day->copy()->subDays(1)->dayOfWeek, $recurrence->data);
                    } elseif ($recurrence->type === 'yearly' && isset($recurrence->data)) {
                        $match = $day->day == $recurrence->data->day && $day->month == $recurrence->data->month;
                    }

                    if ($match) {
                        $top = $week['days'][$i]['count'];

                        $week['days'][$i]['count'] = $week['days'][$i]['count'] + 1;

                        $week['reminders'][] = [
                            'reminder' => $reminder,
                            'top' => $top,
                            'left' => $i,
                            'date' => $day->toDateString(),
                        ];
                    }
                }
            }
            unset($week);
        }

        return $weeks;
    }


    public function getNavigationData(int $year, int $month): array
    {
        $current = Carbon::create($year, $month, 1);
        $previous = $current->copy()->subMonth();
        $next = $current->copy()->addMonth();
        $today = Carbon::today();

        return [
            'previous' => ['year' => $previous->year, 'month' => $previous->month],
            'next' => ['year' => $next->year, 'month' => $next->month],
            'today' => ['year' => $today->year, 'month' => $today->month],
            'is_current' => $this->isCurrentMonthSelected($this->data->getCurrentYear(), $this->data->getCurrentMonth()),
        ];
    }

    public function isCurrentMonthSelected(int $year, int $month): bool
    {
        $now = Carbon::now();

        return $year === $now->year && $month === $now->month;
    }


    public function getDataView(int $year, int $month): CalendarData
    {
        $startOfWeek = Carbon::createFromDate($year, $month, null)->startOfWeek();

        $data = $this->data
            ->startOfWeek($startOfWeek)
            ->monthRange($startOfWeek, $startOfWeek->copy()->addDays(35))
            ->setCurrentMonth($month)
            ->setCurrentYear($year)
            ->weeks($this->rows($year, $month))
            ->setNavigationData($this->getNavigationData($year, $month));

        return $data;
    }
}
