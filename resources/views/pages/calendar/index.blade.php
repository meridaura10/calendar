<!DOCTYPE html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dracula">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calendar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-base-200 min-h-[100vh]">
   <div class="p-8">
       <div class="pb-16">
            <div class="flex  items-center">
                <div class="flex flex-1 gap-2 items-center">
                    <a href="{{ route('profile.edit') }}">
                        <x-secondary-btn>
                            Профіль
                        </x-secondary-btn>
                    </a>
                    <a @if(!$navigate['is_current']) href="{{ route('calendar.index', $navigate['today'])  }}" @endif>
                        <x-secondary-btn
                            :disabled="$navigate['is_current']">
                            Сьогодні
                        </x-secondary-btn>
                    </a>
                </div>
                <div class="flex flex-1 items-center justify-center gap-3">
                    <a href="{{ route('calendar.index', $navigate['previous'])  }}">
                        <button
                            class="btn border border-gray-200  hover:border-gray-300 border-opacity-50 btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28"
                                 fill="currentColor">
                                <path
                                    d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z"></path>
                            </svg>
                        </button>
                    </a>
                    <div class="text-xl px-2 font-bold">
                        {{ \Illuminate\Support\Carbon::createFromDate($current_year, $current_month,1)->monthName }} {{$current_year}}
                    </div>
                    <a href="{{ route('calendar.index', $navigate['next'])  }}">
                        <button
                            class="btn border border-gray-200  hover:border-gray-300 border-opacity-50 btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28"
                                 fill="currentColor">
                                <path
                                    d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z"></path>
                            </svg>
                        </button>
                    </a>
                </div>
                <div class="gap-1 flex-1 justify-end flex">
                    <div class="">
                        <a href="{{ route('event.create') }}">
                            <x-secondary-btn>
                                Нова подія
                            </x-secondary-btn>
                        </a>
                        <a href="{{ route('reminder.create') }}">
                            <x-secondary-btn>
                                Нове нагадуванння
                            </x-secondary-btn>
                        </a>
                    </div>
                </div>
            </div>
       </div>
       <x-calendar.body :weeks="$weeks" :start_week="$start_week" />
   </div>
</body>
</html>
