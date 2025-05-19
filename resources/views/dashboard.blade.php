<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div x-data="{ mobileMenuOpen: false, userMenuOpen: false }" class="bg-white">
        <!-- Mobile menu -->
        <div class="relative z-50 lg:hidden" x-show="mobileMenuOpen" x-transition>
            <div class="fixed inset-0 bg-gray-900/80" @click="mobileMenuOpen = false"></div>
            <div class="fixed inset-0 flex">
                <div class="relative mr-16 w-full max-w-xs">
                    <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                        <button @click="mobileMenuOpen = false" class="-m-2.5 p-2.5">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Sidebar -->
                    <div class="flex flex-col bg-gray-900 px-6 pb-4 text-white">
                        <div class="h-16 flex items-center">
                            <img class="h-8 w-auto"
                                src="https://tailwindui.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                                alt="Logo">
                        </div>
                        <nav class="flex flex-col gap-y-5">
                            <ul class="space-y-2">
                                <li><a href="#" class="block p-2 rounded-md hover:bg-gray-800">Home</a></li>
                                <li><a href="#" class="block p-2 rounded-md hover:bg-gray-800">Budgeting</a></li>
                                <li><a href="#" class="block p-2 rounded-md hover:bg-gray-800">Grafik</a></li>
                            </ul>
                            <div class="text-xs text-gray-400 mt-4">Riwayat Keuangan</div>
                            <ul class="space-y-2 mt-2">
                                <li><a href="#" class="block p-2 rounded-md hover:bg-gray-800">Input Saldo</a></li>
                                <li><a href="#" class="block p-2 rounded-md hover:bg-gray-800">Pengeluaran</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col bg-gray-900 px-6 pb-4 text-white">
            <div class="h-16 flex items-center">
                <img class="h-8 w-auto"
                    src="https://tailwindui.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Logo">
            </div>
            <nav class="flex flex-col gap-y-5">
                <ul class="space-y-2">
                    <li><a href="#" class="block p-2 rounded-md bg-gray-800">Home</a></li>
                    <li><a href="#" class="block p-2 rounded-md hover:bg-gray-800">Budgeting</a></li>
                    <li><a href="#" class="block p-2 rounded-md hover:bg-gray-800">Grafik</a></li>
                </ul>
                <div class="text-xs text-gray-400 mt-4">Riwayat Keuangan</div>
                <ul class="space-y-2 mt-2">
                    <li><a href="#" class="block p-2 rounded-md hover:bg-gray-800">Input Saldo</a></li>
                    <li><a href="#" class="block p-2 rounded-md hover:bg-gray-800">Pengeluaran</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="lg:pl-72">
            <div class="sticky top-0 z-40 flex h-16 items-center border-b bg-white px-4 shadow-sm">
                <button class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="mobileMenuOpen = true">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <div class="ml-auto flex items-center gap-x-4">
                    <div class="relative">
                        <button @click="userMenuOpen = !userMenuOpen" @click.away="userMenuOpen = false"
                            class="flex items-center">
                            <img class="h-8 w-8 rounded-full"
                                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                alt="">
                            <span class="ml-3 text-sm font-semibold text-gray-900">User</span>
                            <svg class="ml-2 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06 0L10 10.94l3.71-3.73a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 010-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="userMenuOpen" x-transition
                            class="absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg py-2 z-50">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                        </div>
                    </div>
                </div>
            </div>

            <main class="py-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    <!-- Your content -->
                    <div class="bg-white p-6 rounded-md shadow">
                        <h1 class="text-2xl font-semibold">Selamat datang di Dashboard</h1>
                        <p class="mt-2 text-gray-600">Ini adalah tampilan dashboard kamu yang dimasukkan ke dalam Laravel Breeze.</p>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
