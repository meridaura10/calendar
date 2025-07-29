<div class="pt-14">
    <div class="max-w-2xl mx-auto p-6">
        <div class="card bg-base-100 shadow-xl p-6">
            <h2 class="card-title text-2xl font-bold mb-6">
                {{ isset($event->id) ? 'Редагувати подію' : 'Створити подію' }}
            </h2>

            <form action="{{ isset($event->id) ? route('event.update', $event->id) : route('event.store') }}"
                  method="POST" class="space-y-6">
                @csrf
                @if(isset($event->id))
                    @method('PUT')
                @else
                    @method('POST')
                @endif

                <!-- Title -->
                <div class="form-control">
                    <label for="title" class="label text-gray-300">Заголовок</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $event?->title) }}"
                           class="input input-bordered w-full bg-base-200 text-gray-100 focus:bg-base-100 focus:text-white"
                           required>
                    @error('title')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @endif
                </div>

                <!-- Color -->
                <div class="form-control">
                    <label for="color" class="label text-gray-300">Колір</label>
                    <input type="color" name="color" id="color" value="{{ old('color', $event?->color) }}"
                           class="input input-bordered w-full h-12 bg-base-200 focus:bg-base-100">
                    @error('color')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @endif
                </div>

                <!-- Start Datetime -->
                <div class="form-control">
                    <label for="start_datetime" class="label text-gray-300">Дата початку</label>
                    <input type="datetime-local" name="start_datetime" id="start_datetime"
                           value="{{ old('start_datetime', $event?->start_datetime?->format('Y-m-d\TH:i')) }}"
                           class="input input-bordered w-full bg-base-200 text-gray-100 focus:bg-base-100 focus:text-white"
                           required>
                    @error('start_datetime')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @endif
                </div>

                <!-- End Datetime -->
                <div class="form-control">
                    <label for="end_datetime" class="label text-gray-300">Дата закінчення</label>
                    <input type="datetime-local" name="end_datetime" id="end_datetime"
                           value="{{ old('end_datetime', $event?->end_datetime ? $event?->end_datetime?->format('Y-m-d\TH:i') : '') }}"
                           class="input input-bordered w-full bg-base-200 text-gray-100 focus:bg-base-100 focus:text-white">
                    @error('end_datetime')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @endif
                </div>

                <!-- Is Completed -->
                <div class="form-control">
                    <label class="label cursor-pointer flex items-center">
                        <input type="hidden" name="is_completed" value="0"/>
                        <input type="checkbox" name="is_completed" id="is_completed"
                               value="1" {{ old('is_completed', $event?->is_completed) ? 'checked' : '' }}
                               class="checkbox checkbox-primary bg-base-200 text-purple-400 focus:ring-purple-500">
                        <span class="label-text ml-2 text-gray-300">Виконано</span>
                    </label>
                    @error('is_completed')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @endif
                </div>

                <input class="hidden" type="text" name="user_id" id="user_id" value="{{ auth()->id() }}">

                <!-- Submit Button -->
                <div class="form-control">
                    <div class="">
                        <button type="submit"
                                class="btn btn-primary w-full text-white bg-purple-600 hover:bg-purple-700">
                            Зберегти зміни
                        </button>
                    </div>
                </div>
            </form>

           @if(isset($event->id))
                <form method="POST" action="{{ route('event.destroy', $event) }}" class="mt-3">
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
