@props([
    'reminders'
])

<div x-data="{ open: false }">
    @foreach(collect($reminders) as $key => $reminder)
        <a href="{{ route('reminder.edit', $reminder['reminder']->id) }}">
        <div
            style="
                top: {{ $reminder['top'] * 25 + 40 }}px;
                left: calc({{ $reminder['left'] }} * 100% / 7);
                width: 100%;
                 background-color: {{ $reminder['reminder']['color'] }};
                max-width: calc(100% / 7);
            "
            class="h-[25px] rounded-lg pl-2 absolute bg-orange-200"
        >
            <span class="text-sm text-black">{{ $reminder['reminder']->title }}</span>
        </div>
        </a>
    @endforeach

    @if(count($reminders) > 3)
        <button
            @click="open = !open"
            class="absolute text-xs text-white bg-gray-600 rounded px-1"
            style="top: {{ 3 * 25 + 40 }}px; left: 0;"
        >
            + ще {{ count($reminders) - 3 }} подій
        </button>

        <div x-show="open" class="absolute w-full bg-gray-800 rounded z-10">
            @foreach(array_slice($reminders, 3) as $reminder)
                <a href="{{ route('reminder.edit', $reminder['reminder']->id) }}">
                <div
                    style="
                        left: calc({{ $reminder['left'] }} * 100% / 7);
                           background-color: {{ $reminder['reminder']['color'] }};
                        max-width: calc(100% / 7);
                    "
                    class="h-[25px] z-11 border-l border border-white mb-1 rounded-lg pl-2 border-t border-l border-gray-400 relative bg-orange-300"
                >
                    <span class="text-sm text-black">{{ $reminder['reminder']->title }}</span>
                </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
