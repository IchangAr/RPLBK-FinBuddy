<x-guest-layout>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-22 w-auto" src="{{ asset('img/FinBuddy Logo.png') }}" alt="FinBuddy">
            <h2 class="mt-8 text-center text-3xl font-bold tracking-tight text-gray-900">
                Daftar Akun Baru
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Lengkapi informasi di bawah ini untuk membuat akun FinBuddy Anda.
            </p>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Username -->
                <div>
                    <x-input-label for="name" :value="__('Username')" />
                    <x-text-input id="name" name="name" type="text" :value="old('name')" required autofocus autocomplete="username"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900
                        outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400
                        focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" :value="old('email')" required autocomplete="email"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900
                        outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400
                        focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" name="password" type="password" required autocomplete="new-password"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900
                        outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400
                        focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"/>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900
                        outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400
                        focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"/>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Submit -->
                <div class="pt-2">
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-[#1a5fb4] px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm/6 text-gray-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-[#1a5fb4] hover:text-indigo-500">Masuk</a>
            </p>
        </div>
    </div>
</x-guest-layout>
