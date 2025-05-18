<x-guest-layout>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-20 w-auto" src="img/FinBuddy Logo.png" alt="FinBuddy">
            <h2 class="mt-8 text-center text-3xl font-bold tracking-tight text-gray-900">
                Masuk ke Akun Anda
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Silakan masukkan email dan kata sandi untuk melanjutkan.
            </p>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                    <div class="mt-2">
                        <input type="email" name="email" id="email" autocomplete="email" required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm"
                            value="{{ old('email') }}">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-sm text-indigo-600 hover:text-indigo-500">Lupa Password?</a>
                        @endif
                    </div>
                    <div class="mt-2">
                        <input type="password" name="password" id="password" autocomplete="current-password" required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>

                <!-- Submit -->
                <div class="mt-10">
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-[#1a5fb4] px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-[#1f73da] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Sign in
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-semibold text-[#1a5fb4] hover:text-[#1f73da]">Daftar</a>
            </p>
        </div>
    </div>
</x-guest-layout>
