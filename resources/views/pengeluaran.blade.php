<x-app-layout>
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 mb-10">
        <div class="mt-6 bg-white p-8 rounded-lg shadow-lg">
            <div class="mb-4">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center text-sm font-semibold text-[#3B577D] hover:text-[#4d71a3]">
                    <span class="text-2xl mr-2">←</span>Kembali ke Home
                </a>
            </div>

            <div class="sm:flex-auto mb-7">
                <p class="ml-8 text-sm text-gray-600 leading-tight mb-1">Input</p>
                <h1 class="text-3xl font-bold leading-tight">Pengeluaran Keuangan Kamu</h1>
            </div>

            <form id="formPengeluaran" action="{{ route('pengeluaran.simpan') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-2">Silahkan Pilih Kategori</label>
                    <select id="kategori" name="kategori"
                        class="w-full rounded-md border border-gray-300 bg-white py-2 pl-4 pr-10 text-sm text-gray-800 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300"
                        required>
                        <option value="" {{ old('kategori') ? '' : 'selected' }}>Pilih Kategori</option>
                        <option value="kebutuhan" {{ old('kategori') == 'kebutuhan' ? 'selected' : '' }}>Kebutuhan</option>
                        <option value="keinginan" {{ old('kategori') == 'keinginan' ? 'selected' : '' }}>Keinginan</option>
                        <option value="tabungan" {{ old('kategori') == 'tabungan' ? 'selected' : '' }}>Tabungan</option>
                        <option value="utang" {{ old('kategori') == 'utang' ? 'selected' : '' }}>Utang & Credit</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Saldo Saat Ini</label>
                    <span id="saldo-kategori" class="text-sm text-gray-600">Rp. -</span>
                </div>

                <p class="block text-sm font-semibold text-gray-700 mb-2">Input Pengeluaran Anda</p>
                <div class="flex items-center gap-3 mb-6">
                    <label for="saldo" class="text-sm text-gray-600 whitespace-nowrap">Rp</label>
                    <input type="number" name="saldo" id="saldo"
                        class="border rounded-md px-2 py-2 text-sm w-full" placeholder="Masukkan saldo"
                        value="{{ old('saldo') }}" required>
                </div>

                <div class="mb-6">
                    <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">Catatan</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3"
                        class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-800 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300"
                        placeholder="Tambahkan catatan pengeluaran..." required>{{ old('deskripsi') }}</textarea>
                </div>

                <div class="text-center">
                    <button type="submit"
                        class="inline-flex items-center rounded-md bg-[#3B577D] px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#4d71a3] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                        Simpan Pengeluaran
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toast Success -->
    <div x-data="{ show: false, message: '' }" x-show="show"
         x-transition
         x-cloak
         x-init="$watch('show', val => val && setTimeout(() => show = false, 3000))"
         id="toast-success"
         class="fixed top-5 right-5 z-50 rounded-lg bg-green-600 text-white px-4 py-2 text-sm shadow-lg">
        <span x-text="message"></span>
    </div>

    <!-- Toast Error -->
    <div x-data="{ show: false, message: '' }" x-show="show"
         x-transition
         x-cloak
         x-init="$watch('show', val => val && setTimeout(() => show = false, 3000))"
         id="toast-error"
         class="fixed top-5 right-5 z-50 rounded-lg bg-red-600 text-white px-4 py-2 text-sm shadow-lg">
        <span x-text="message"></span>
    </div>

    <!-- Success Modal (Initially hidden, shown via JavaScript) -->
    <div x-data="{ open: false, message: '' }" x-cloak id="success-modal">
        <div x-show="open" x-transition class="fixed inset-0 z-40 flex items-center justify-center bg-black/50">
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
                    <p class="mt-2 text-sm text-gray-600" x-text="message"></p>
                    <button @click="open = false"
                            class="mt-4 inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Ensure Alpine.js is loaded
            if (typeof Alpine === 'undefined') {
                console.error('Alpine.js is not loaded. Please include it in your project.');
                return;
            }

            const saldoKategori = {!! json_encode($saldoKategori ?? []) !!};
            const kategoriSelect = document.getElementById('kategori');
            const saldoInput = document.getElementById('saldo');
            const deskripsiInput = document.getElementById('deskripsi');
            const saldoOutput = document.getElementById('saldo-kategori');
            const form = document.getElementById('formPengeluaran');
            const toastSuccess = document.getElementById('toast-success');
            const toastError = document.getElementById('toast-error');
            const successModal = document.getElementById('success-modal');

            // Function to show toast
            function showToast(type, message) {
                const toast = type === 'success' ? toastSuccess : toastError;
                toast.__x.$data.message = message;
                toast.__x.$data.show = true;
            }

            // Function to show success modal
            function showSuccessModal(message) {
                successModal.__x.$data.message = message;
                successModal.__x.$data.open = true;
            }

            // Function to update remaining balance
            function updateSaldoTersisa() {
                const kategori = kategoriSelect.value;
                const pengeluaran = Math.max(0, Number(saldoInput.value) || 0);
                const saldoAwal = saldoKategori[kategori] ?? 0;
                const saldoTersisa = saldoAwal - pengeluaran;

                if (kategori && saldoKategori.hasOwnProperty(kategori)) {
                    saldoOutput.textContent = saldoTersisa >= 0
                        ? 'Rp. ' + saldoTersisa.toLocaleString('id-ID')
                        : 'Saldo tidak cukup! (Rp. ' + saldoTersisa.toLocaleString('id-ID') + ')';
                } else {
                    saldoOutput.textContent = 'Rp. -';
                }
            }

            // Event listeners for real-time balance update
            kategoriSelect.addEventListener('change', updateSaldoTersisa);
            saldoInput.addEventListener('input', updateSaldoTersisa);

            // Form submission with AJAX
            form.addEventListener('submit', (e) => {
                e.preventDefault(); // Prevent default form submission

                const kategori = kategoriSelect.value;
                const saldo = saldoInput.value.trim();
                const deskripsi = deskripsiInput.value.trim();
                const saldoAwal = saldoKategori[kategori] ?? 0;
                const pengeluaran = parseFloat(saldo);

                // Client-side validation
                if (!kategori) {
                    showToast('error', 'Silakan pilih kategori terlebih dahulu.');
                    return;
                }

                if (!saldo || pengeluaran <= 0) {
                    showToast('error', 'Masukkan nominal saldo yang valid.');
                    return;
                }

                if (!deskripsi) {
                    showToast('error', 'Harap tambahkan catatan pengeluaran.');
                    return;
                }

                if (saldoAwal - pengeluaran < 0) {
                    showToast('error', 'Saldo kategori tidak cukup, gunakan kategori lain.');
                    return;
                }

                // Prepare form data
                const formData = new FormData(form);

                // Send AJAX request
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccessModal(data.message || 'Pengeluaran berhasil disimpan!');
                        form.reset(); // Reset form
                        updateSaldoTersisa(); // Update balance display
                        saldoKategori[kategori] = data.newSaldo || saldoKategori[kategori] - pengeluaran; // Update local saldoKategori
                    } else {
                        showToast('error', data.message || 'Terjadi kesalahan saat menyimpan pengeluaran.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', 'Terjadi kesalahan jaringan. Silakan coba lagi.');
                });
            });
        });
    </script>
</x-app-layout>
