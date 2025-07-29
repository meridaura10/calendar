@props([
    'events'
])

<div x-data="{ open: false }">
    @foreach(collect($events)->take(3) as $key => $event)
        <a href="{{ route('event.edit', $event['event']->id) }}">
            <div
                style="
                top: {{ $key * 25 + 40 }}px;
                left: calc({{ $event['left'] }} * 100% / 7);
                width: calc({{ $event['cell'] }} * 100% / 7);
                background-color: {{ $event['event']['color'] }};
            "
                class="h-[25px] rounded-lg pl-2 absolute bg-orange-200"
            >
                <span class="text-sm text-black">{{ $event['event']->title }}</span>
            </div>
        </a>
    @endforeach

    @if(count($events) > 3)
        <button
            @click="open = !open"
            class="absolute text-xs text-white bg-gray-600 rounded px-1"
            style="top: {{ 3 * 25 + 40 }}px; left: 0;"
        >
            + ще {{ count($events) - 3 }} подій
        </button>

        <div x-show="open" class="absolute w-full bg-gray-800 rounded z-10">
            @foreach(array_slice($events, 3) as $event)
                <a href="{{ route('event.edit', $event['event']->id) }}">
                    <div
                        style="
                        left: calc({{ $event['left'] }} * 100% / 7);
                        width: calc({{ $event['cell'] }} * 100% / 7);
                        background-color: {{ $event['event']['color'] }};
                    "
                        class="h-[25px] z-11 border-l border border-white mb-1 rounded-lg pl-2 border-t border-l border-gray-400 relative bg-orange-300"
                    >
                        <span class="text-sm text-black">{{ $event['event']->title }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
