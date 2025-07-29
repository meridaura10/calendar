<x-layouts.app.app>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-base-300 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header class="flex justify-between">
                            <div>
                                <h2 class="text-lg font-medium text-gray-200">
                                    {{ __('Profile Information') }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-400">
                                    {{ __("Update your account's profile information and email address.") }}
                                </p>

                            </div>
                            <form class="" action="{{ route('logout') }}" method="POST">
                                @csrf
                                @method('post')
                                <x-primary-button>{{ __('Logout') }}</x-primary-button>
                            </form>
                        </header>

                        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>


                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center justify-between gap-4">
                                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                                    <a href="{{ route('telegram.link') }}">
                                        <x-primary-button type="button">{{ __('Telegram') }}</x-primary-button>
                                    </a>
                                </div>
                                <div>
                                    <a href="{{ route('password.edit') }}">
                                        <x-primary-button type="button">{{ __('New_passwor') }}</x-primary-button>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app.app>
