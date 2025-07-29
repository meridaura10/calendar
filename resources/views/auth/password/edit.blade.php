<x-guest-layout>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('post')

        @foreach($errors->get('updatePassword') as $mes)
            {{$mew}}
        @endforeach

        <div class="mt-4">
            <x-input-label for="current_password" :value="__('Current_password')" />

            <x-text-input id="current_password" class="block mt-1 w-full"
                          type="password"
                          name="current_password"
                          required/>

            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('New_Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Save') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
