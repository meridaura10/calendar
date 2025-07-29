@props([
    'week',
])

<div class="relative">
    <div class="flex">
        @foreach($week['days'] as $day)
            <x-calendar.day :day="$day"/>
        @endforeach
    </div>
        <x-calendar.events :events="$week['events']" />
        <x-calendar.reminders :reminders="$week['reminders']" />
</div>
