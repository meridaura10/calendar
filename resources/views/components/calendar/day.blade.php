@props([
    'day' => null,
])

<div
    class="relative flex-1"
>
    <div class="relative w-full border-t border-l border-gray-400
          @if(!$day['is_current_month']) bg-base-300 @else bg-base-100 @endif
          h-[160px]
          flex items-center justify-center calendar_cell hover:bg-gray-700 transition-colors"
    >
{{--        <button--}}
{{--            class="bg-blue-400 w-[20px] h-[20px] text-white flex justify-center rounded-full items-center calendar_cell-btn"--}}
{{--        >--}}
{{--            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20ZM13 9.41V7H11V10.59L14.29 13.88L15.71 12.46L13 9.41ZM12 17C13.1 17 14 16.1 14 15C14 13.9 13.1 13 12 13C10.9 13 10 13.9 10 15C10 16.1 10.9 17 12 17Z" fill="#FFFFFF"/>--}}
{{--            </svg>--}}
{{--        </button>--}}

{{--        <button--}}
{{--            class="bg-blue-400 w-[20px] h-[20px] text-white flex justify-center rounded-full items-center calendar_cell-btn"--}}
{{--        >--}}
{{--            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                <path d="M19 4H18V2H16V4H8V2H6V4H5C3.89 4 3.01 4.9 3.01 6L3 20C3 21.1 3.89 22 5 22H19C20.1 22 21 21.1 21 20V6C21 4.9 20.1 4 19 4ZM19 20H5V9H19V20ZM19 8H5V6H19V8ZM12 11H17V13H12V11ZM7 15H17V17H7V15Z" fill="#4ECDC4"/>--}}
{{--            </svg>--}}
{{--        </button>--}}
        <div class="
              @if(!$day['is_current_month']) text-gray-500 @endif
              calendar_cell-d text-xl absolute right-[6px] top-[6px]"
        >
            {{ \Illuminate\Support\Carbon::parse($day['date'])->format('d') }}
        </div>
        <div>
            @if(\Illuminate\Support\Carbon::parse($day['date'])->isToday())
                <div class="w-12 h-12 bg-blue-300 rounded-br-full absolute left-0 top-0"></div>
            @endif
        </div>
    </div>
</div>
