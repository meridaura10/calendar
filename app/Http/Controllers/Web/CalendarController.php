<?php

namespace App\Http\Controllers\Web;

use App\contracts\Calendar\CalendarContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\CalendarRequest;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class CalendarController extends Controller
{
    public function __invoke(CalendarRequest $request, CalendarContract $calendar): View
    {
        $year = $request->get('year') ?? Carbon::now()->year;
        $month = $request->get('month') ?? Carbon::now()->month;

        return view('pages.calendar.index', $calendar->getDataView($year, $month));
    }
}
