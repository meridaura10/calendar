<div>
    <div class="max-w-2xl mx-auto p-6 mt-10">
        <div class="card bg-base-100 shadow-xl p-6" style="background-color: #282a36; color: #f8f8f2;">
            <h2 class="card-title text-2xl font-bold mb-6">
                {{ $form->reminder->id ? 'Редагувати нагадування' : 'Створити нагадування' }}
            </h2>

            <form wire:submit="save" class="space-y-8">
                <div class="form-control">
                    <label for="title" class="label text-gray-300">Назва</label>
                    <input type="text" wire:model="form.title" id="title"
                           class="input input-bordered w-full bg-base-200 text-gray-100 focus:bg-base-100 focus:text-white"
                           required>
                    @error('form.title') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @endif
                </div>

                <div class="form-control">
                    <label for="color" class="label text-gray-300">Колір</label>
                    <input type="color" wire:model="form.color" id="color"
                           class="input input-bordered w-full h-12 bg-base-200 focus:bg-base-100">
                    @error('form.color') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @endif
                </div>

                <div class="form-control">
                    <label for="datetime" class="label text-gray-300">Дата і час</label>
                    <input type="datetime-local" wire:model="form.datetime" id="datetime"
                           class="input input-bordered w-full bg-base-200 text-gray-100 focus:bg-base-100 focus:text-white"
                           required>
                    @error('form.datetime') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @endif
                </div>

                <div class="form-control">
                    <label class="label text-gray-300 pb-4">Регулярність</label>
                    <div class="grid grid-cols-2 gap-2 sm:grid-cols-3">
                        @foreach([
                            ['value' => 'none', 'label' => 'Без повторення'],
                            ['value' => 'daily', 'label' => 'Кожен день'],
                            ['value' => 'days', 'label' => 'Щотижня (вибрати дні)'],
                            ['value' => 'month', 'label' => 'Кожен місяць (вказаного числа місяця)'],
                            ['value' => 'yearly', 'label' => 'Кожен рік (вказаного дня року)']
                        ] as $option)
                            <button
                                type="button"
                                wire:click="setType('{{ $option['value'] }}')"
                                class="btn py-9 {{ $type === $option['value'] ? 'btn-primary bg-purple-600 hover:bg-purple-700 text-white' : 'btn-ghost bg-base-200 text-gray-300 hover:bg-base-300' }} transition-colors duration-200"
                            >
                                {{ $option['label'] }}
                            </button>
                        @endforeach
                    </div>
                    @error('form.recurrence_type') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @endif

                    <div class="@if($type !== 'days') hidden @endif form-control mt-4 pl-4">
                        <label class="label text-gray-300">Вибрати дні</label>
                        <div class="space-y-2">
                            @foreach(['Понеділок', 'Вівторок', 'Середа', 'Четвер', 'Пятниця', 'Субота', 'Неділя'] as $index => $day)
                                <div>
                                    <label class="flex items-center">
                                        <input
                                            type="checkbox"
                                            value="{{ $index }}"
                                            wire:model.live="days"
                                            class="checkbox checkbox-primary bg-base-200 text-purple-400">
                                        <span class="ml-2 text-gray-300">{{ $day }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('days') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @endif
                    </div>

                    <div class="@if($type !== 'month') hidden @endif form-control mt-4 pl-4">
                        <label for="month" class="label text-gray-300">Число місяця</label>
                        <input type="number"
                               wire:model="month"
                               id="month"
                               @if($type == 'month')   min="1" max="31" @endif

                               class="input input-bordered w-full bg-base-200 text-gray-100 focus:bg-base-100 focus:text-white">
                        @error('day_of_month') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @endif
                    </div>

                    <div class="@if($type !== 'yearly') hidden @endif form-control mt-4 pl-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="yearly_day" class="label text-gray-300">Число місяця</label>
                                <input type="number"
                                       wire:model="yearly.day"
                                       id="yearly_day"
                                       @if($type == 'yearly')   min="1" max="31" @endif

                                       class="input input-bordered w-full bg-base-200 text-gray-100 focus:bg-base-100 focus:text-white">
                                @error('yearly.day') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @endif
                            </div>
                            <div>
                                <label for="yearly_month" class="label text-gray-300">Місяць</label>
                                <input type="number"
                                       wire:model="yearly.month"
                                       id="yearly_month"
                                       @if($type == 'yearly')   min="1" max="12" @endif
                                       class="input input-bordered w-full bg-base-200 text-gray-100 focus:bg-base-100 focus:text-white">
                                @error('yearly.month') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-control">
                    <label class="label text-gray-300">Виконано</label>
                    <input type="checkbox" wire:model.live="form.is_completed"
                           class="checkbox checkbox-primary bg-base-200 text-purple-400">
                </div>

                <div class="form-control">
                    <button type="submit" class="btn btn-primary w-full text-white bg-purple-600 hover:bg-purple-700">
                        Зберегти зміни
                    </button>
                </div>
            </form>

            @if(isset($form->reminder->id))
                <form method="POST" action="{{ route('reminder.destroy', $form->reminder) }}" class="mt-3">
                    @csrf
                    @method('POST')

                    <div class="form-control">
                        <div class="">
                            <button type="submit" class="btn btn-error w-full text-white">
                                Видалити
                            </button>
                        </div>
                    </div>
                </form>
            @endif


        </div>
    </div>
</div>


