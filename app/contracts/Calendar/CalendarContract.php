<?php

namespace App\contracts\Calendar;

use App\Services\Calendar\CalendarData;

interface CalendarContract
{
    public function getDataView(int $year, int $month): CalendarData;
}
