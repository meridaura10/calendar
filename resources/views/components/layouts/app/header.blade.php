<header class="bg-gray-800 shadow-lg">
    <div class="w-full max-w-[1200px] mx-auto">
        <div class="p-3">
            <div class="flex justify-between items-center">
                <div class="flex gap-2">
                    <a href="{{ route('calendar.index') }}">
                        <x-secondary-btn>
                            Календарь
                        </x-secondary-btn>
                    </a>
                </div>
                <div>
                    {{ auth()->user()->email }}
                </div>
            </div>
        </div>
    </div>
</header>
