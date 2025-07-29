<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReminderRequest;
use App\Models\Reminder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReminderController extends Controller
{
    use AuthorizesRequests;

    public function edit(Reminder $reminder): View
    {
        return view('pages.reminder.edit', ['reminder' => $reminder]);
    }

    public function create(): View
    {
        return view('pages.reminder.create', ['reminder' => new Reminder(['user_id' => auth()->id()])]);
    }

    public function destroy(Reminder $reminder): RedirectResponse
    {
        $this->authorize('destroy', $reminder);

        $reminder->delete();

        return redirect()->route('calendar.index');
    }
}
