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

                <div class="mt-4">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email
                    </label>
                    <input type="email" name="email" id="email" autocomplete="email" required
                        class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-1.5 text-base text-gray-900
           shadow-sm placeholder-gray-400
           focus:border-[#3B577D] focus:ring-2 focus:ring-[#3B577D] focus:outline-none
           transition duration-200 ease-in-out"
                        value="{{ old('email') }}" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Password -->
                <div>
                    <div class="mt-4 relative">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" id="password" autocomplete="current-password" required
                            placeholder="••••••••"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2 pr-10 text-base text-gray-900
           shadow-sm placeholder-gray-400
           focus:border-[#3B577D] focus:ring-2 focus:ring-[#3B577D] focus:outline-none
           transition duration-200 ease-in-out sm:text-sm" />
                        <!-- Tombol mata untuk toggle password -->
                        <button type="button" id="togglePassword" aria-label="Toggle password visibility"
                            class="mt-6 absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <script>
                        document.getElementById('togglePassword').addEventListener('click', function() {
                            const passwordInput = document.getElementById('password');
                            const eyeIcon = document.getElementById('eyeIcon');
                            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                            passwordInput.setAttribute('type', type);

                            // Ganti icon mata terbuka dan tertutup
                            if (type === 'text') {
                                eyeIcon.innerHTML = `
        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.679-4.342m1.846-1.734A9.97 9.97 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.97 9.97 0 01-3.602 4.789M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
      `;
                            } else {
                                eyeIcon.innerHTML = `
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
      `;
                            }
                        });
                    </script>
                    <div class="flex justify-end mt-2">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-sm text-[#3B577D] hover:text-[#4d71a3]">Lupa Password?</a>
                        @endif
                    </div>

                </div>

                <!-- Submit -->
                <div class="mt-10">
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-[#3B577D] px-3 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#4d71a3] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#3B577D]">
                        Masuk
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-semibold text-[#3B577D] hover:text-[#4d71a3]">Daftar</a>
            </p>
        </div>
    </div>
</x-guest-layout>
