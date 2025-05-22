<div x-data="{ open: true }" x-cloak>
    <!-- Overlay -->
    <div x-show="open" x-transition class="fixed inset-0 z-40 flex items-center justify-center bg-black/50">
        <!-- Modal -->
        <div
            @click.away="open = false"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative w-full max-w-md rounded-lg bg-white p-6 shadow-xl z-50"
        >
            <div class="text-center">
                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Berhasil!</h3>
                <p class="mt-2 text-sm text-gray-600">{{ session('success') }}</p>
                <button @click="open = false"
                        class="mt-4 inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
