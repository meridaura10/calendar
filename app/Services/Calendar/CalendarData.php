<?php

namespace App\Services\Calendar;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface;

class CalendarData extends AttributeBag implements Arrayable
{
    static function make(...$arg): static
    {
        return new static(...$arg);
    }

    public function toArray(): array
    {
        return $this->attributes;
    }

    public function events(Collection $events): static
    {
        $this->set('events', $events);

        return $this;
    }

    public function getEvents(): Collection
    {
        return $this->get('events');
    }

    public function reminders(Collection $reminders): static
    {
        $this->set('reminders', $reminders);

        return $this;
    }

    public function weeks(array $weeks): static
    {
        $this->set('weeks', $weeks);

        return $this;
    }

    public function getCurrentMonth(): int
    {
        return $this->get('current_month', Carbon::now()->month);
    }

    public function setCurrentMonth(int $month): static
    {
        $this->set('current_month', $month);

        return $this;
    }

    public function setNavigationData(array $data): static
    {
        $this->set('navigate', $data);

        return $this;
    }

    public function setCurrentYear(int $year): static
    {
        $this->set('current_year', $year);

        return $this;
    }

    public function getCurrentYear(): int
    {
        return $this->get('current_year', Carbon::now()->year);
    }

    public function startOfWeek(Carbon $carbon): static
    {
        $this->set('start_week', $carbon);

        return $this;
    }

    public function days(array $days): static
    {
        $this->set('days', $days);

        return $this;
    }

    public function monthRange(Carbon $start, Carbon $end): static
    {
        $this->set('month_start', $start);
        $this->set('month_end', $end);

        return $this;
    }

    public function getMonthRange(): array
    {
        return [
            $this->get('month_start'),
            $this->get('month_end')
        ];
    }

    public function getCurrentDay(): Carbon
    {
        return $this->get('current_day', Carbon::now());
    }

    public function getDays(): array
    {
        return $this->get('days');
    }
}
