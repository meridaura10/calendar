<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EventController extends Controller
{
    use AuthorizesRequests;

    public function edit(Event $event): View
    {
        return view('pages.event.edit', ['event' => $event]);
    }

    public function update(EventRequest $request, Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        $data = $request->validated();

        $event->fill($data)->save();

        return redirect()->route('calendar.index');
    }

    public function create(): View
    {
        return view('pages.event.create', ['event' => new Event(['user_id' => auth()->id()])]);
    }

    public function store(EventRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Event::query()->create($data);

        return redirect()->route('calendar.index');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $this->authorize('destroy', $event);

        $event->delete();

        return redirect()->route('calendar.index');
    }
}
