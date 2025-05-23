<x-app-layout>
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 mb-10" x-data="pengeluaranApp()">
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

            <form id="formPengeluaran" action="{{ route('pengeluaran.simpan') }}" method="POST" @submit.prevent="submitForm">
                @csrf

                {{-- kategori --}}

                <div class="mb-6">
                    <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-2">Silahkan Pilih
                        Kategori</label>
                    <select id="kategori" name="kategori" x-model="form.kategori" @change="updateSaldoTersisa"
                        class="w-full rounded-md border border-gray-300 bg-white py-2 pl-4 pr-10 text-sm text-gray-800 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300"
                        required>
                        <option value="">Pilih Kategori</option>
                        <option value="kebutuhan">Kebutuhan</option>
                        <option value="keinginan">Keinginan</option>
                        <option value="tabungan">Tabungan</option>
                        <option value="utang">Utang & Credit</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Saldo Saat Ini</label>
                    <span class="text-sm text-gray-600" x-text="saldoTersisaDisplay"></span>
                </div>

                <p class="block text-sm font-semibold text-gray-700 mb-2">Input Pengeluaran Anda</p>
                <div class="flex items-center gap-3 mb-6">
                    <label for="saldo" class="text-sm text-gray-600 whitespace-nowrap">Rp</label>
                    <input type="number" name="saldo" id="saldo" x-model.number="form.saldo" min="0" autofocus
                        class="border rounded-md px-2 py-2 text-sm w-full" placeholder="Masukkan saldo" required
                        @input="updateSaldoTersisa">
                </div>

                <div class="mb-6">
                    <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">Catatan</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3" x-model="form.deskripsi"
                        class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-800 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300"
                        placeholder="Tambahkan catatan pengeluaran..." required></textarea>
                </div>



                <button type="button" @click="openConfirmModal = true"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                    Simpan Pengeluaran
                </button>
            </form>
        </div>

        <!-- Modal Konfirmasi -->
        <div x-show="openConfirmModal" x-transition x-cloak
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div @click.away="openConfirmModal = false" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative w-full max-w-md rounded-lg bg-white p-6 shadow-xl z-50">
                <h2 class="text-lg font-semibold mb-4">Konfirmasi Pengeluaran</h2>
                <p class="text-sm text-gray-600 mb-6">Apakah kamu yakin ingin menyimpan pengeluaran ini?</p>
                <div class="flex justify-end space-x-3">
                    <button @click="openConfirmModal = false"
                        class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-100">Batal</button>
                    <button @click="submitForm" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Setuju
                    </button>
                </div>
            </div>
        </div>

        <!-- Toast Notification -->
        <div x-show="toast.show" x-transition x-cloak
            :class="toast.type === 'success' ? 'bg-green-600' : 'bg-red-600'"
            class="fixed top-5 right-5 z-50 rounded-lg text-white px-4 py-2 text-sm shadow-lg">
            <span x-text="toast.message"></span>
        </div>

        <!-- Success Modal -->
        <div x-show="successModal.open" x-transition x-cloak
            class="fixed inset-0 z-40 flex items-center justify-center bg-black/50">
            <div @click.away="successModal.open = false" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative w-full max-w-md rounded-lg bg-white p-6 shadow-xl z-50">
                <div class="text-center">
                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Berhasil!</h3>
                    <p class="mt-2 text-sm text-gray-600" x-text="successModal.message"></p>
                    <button
                        @click="window.location.href='{{ route('dashboard') }}'"
                        class="mt-4 inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                        Kembali Dashboard
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function pengeluaranApp() {
            return {
                // Data form
                form: {
                    kategori: '',
                    saldo: null,
                    deskripsi: '',
                },
                saldoKategori: {!! json_encode($saldoKategori ?? ['kebutuhan' => 0, 'keinginan' => 0, 'tabungan' => 0, 'utang' => 0]) !!},
                saldoTersisaDisplay: 'Rp. -',

                // Modal & toast state
                openConfirmModal: false,
                toast: {
                    show: false,
                    message: '',
                    type: 'success' // 'success' or 'error'
                },
                successModal: {
                    open: false,
                    message: ''
                },

                updateSaldoTersisa() {
                    const kategori = this.form.kategori;
                    const pengeluaran = Number(this.form.saldo) || 0;
                    const saldoAwal = this.saldoKategori[kategori] ?? null;

                    if (!kategori || saldoAwal === null) {
                        this.saldoTersisaDisplay = 'Rp. -';
                        return;
                    }

                    const saldoTersisa = saldoAwal - pengeluaran;

                    if (saldoTersisa >= 0) {
                        this.saldoTersisaDisplay = 'Rp. ' + saldoTersisa.toLocaleString('id-ID');
                    } else {
                        this.saldoTersisaDisplay = 'Saldo tidak cukup! (Rp. ' + saldoTersisa.toLocaleString('id-ID') + ')';
                    }
                },

                showToast(type, message) {
                    this.toast.type = type;
                    this.toast.message = message;
                    this.toast.show = true;
                    setTimeout(() => {
                        this.toast.show = false;
                    }, 3000);
                },

                showSuccessModal(message) {
                    this.successModal.message = message;
                    this.successModal.open = true;
                },

                resetForm() {
                    this.form.kategori = '';
                    this.form.saldo = null;
                    this.form.deskripsi = '';
                    this.saldoTersisaDisplay = 'Rp. -';
                },

                submitForm() {
                    // Validasi manual sebelum submit
                    if (!this.form.kategori) {
                        this.showToast('error', 'Silakan pilih kategori terlebih dahulu.');
                        this.openConfirmModal = false;
                        return;
                    }
                    if (this.form.saldo === null || this.form.saldo <= 0) {
                        this.showToast('error', 'Masukkan nominal saldo yang valid.');
                        this.openConfirmModal = false;
                        return;
                    }
                    if (!this.form.deskripsi.trim()) {
                        this.showToast('error', 'Harap tambahkan catatan pengeluaran.');
                        this.openConfirmModal = false;
                        return;
                    }

                    const saldoAwal = this.saldoKategori[this.form.kategori] ?? 0;
                    if (saldoAwal - this.form.saldo < 0) {
                        this.showToast('error', 'Saldo kategori tidak cukup, gunakan kategori lain.');
                        this.openConfirmModal = false;
                        return;
                    }

                    this.openConfirmModal = false;

                    // Persiapan form data
                    let data = new FormData();
                    data.append('kategori', this.form.kategori);
                    data.append('saldo', this.form.saldo);
                    data.append('deskripsi', this.form.deskripsi);
                    data.append('_token', '{{ csrf_token() }}');

                    fetch('{{ route('pengeluaran.simpan') }}', {
                        method: 'POST',
                        body: data,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                    })
                        .then(response => {
                            if (!response.ok) throw new Error('Jaringan bermasalah');
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                this.showSuccessModal(data.message || 'Pengeluaran berhasil disimpan!');
                                this.resetForm();
                                // Update saldoKategori lokal dengan saldo baru dari backend (jika ada)
                                if (typeof data.newSaldo === 'number') {
                                    this.saldoKategori[this.form.kategori] = data.newSaldo;
                                } else {
                                    // fallback: kurangi saldo lokal secara manual
                                    this.saldoKategori[this.form.kategori] -= this.form.saldo;
                                }
                                this.updateSaldoTersisa();
                            } else {
                                this.showToast('error', data.message || 'Terjadi kesalahan saat menyimpan pengeluaran.');
                            }
                        })
                        .catch(error => {
                            console.error(error);
                            this.showToast('error', 'Terjadi kesalahan jaringan. Silakan coba lagi.');
                        });
                },
            };
        }
    </script>
</x-app-layout>
