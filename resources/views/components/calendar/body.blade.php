@props([
    'current_day'=> \Illuminate\Support\Carbon::now()->toString(),
    'start_week' => \Illuminate\Support\Carbon::now()->startOfWeek()->toString(),
    'weeks' => [],
])
<div class="">
    <x-calendar.weeks :start_week="$start_week" />
    <div class="grid">
        @foreach($weeks as $week)
            <x-calendar.week :week="$week" />
        @endforeach
    </div>
</div>



