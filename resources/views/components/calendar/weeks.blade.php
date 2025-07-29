@props([
    'start_week',
])

<div class="flex items-center relative">
    @for($i = 0; $i < 7; $i++)
        <div
            class="flex-1  text-sm font-semibold border-l border-gray-400">
            <div class="h-[40px] text-center relative">
                {{ \Illuminate\Support\Carbon::parse($start_week)->addDays($i)->format('D') }}<br>
            </div>
        </div>
    @endFor
</div>
