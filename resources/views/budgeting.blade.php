<x-app-layout>
    <main class="py-2">
        <div class="px-4 sm:px-6 lg:px-8" x-data="budgetingApp()">
            <div>
                <h1 class="ml-8 text-5xl font-bold">Budgeting</h1>
                <p class="text-sm text-gray-600 ml-2">Kelola Keuanganmu yuuuk!</p>
            </div>

            <div class="mt-6 p-6 bg-white bg-opacity-70 backdrop-blur-md rounded-md shadow-md">
                <h2 class="text-lg font-semibold mb-4">Tambah Saldo & Alokasi Budget</h2>
                <form id="form-budgeting" @submit.prevent="confirmAndSubmitForm">
                    @csrf

                    <div class="flex items-center gap-3 mb-4">
                        <label for="saldo" class="text-sm text-gray-600 whitespace-nowrap">Rp</label>
                        <input type="number" name="saldo" id="saldo" x-model.number="form.saldo"
                            @input="handleSaldoInput"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2 pr-10 text-base text-gray-900
                               shadow-sm placeholder-gray-400
                               focus:border-[#3B577D] focus:ring-2 focus:ring-[#3B577D] focus:outline-none
                               transition duration-200 ease-in-out sm:text-sm mr-4"
                            placeholder="Masukkan saldo" required min="0">
                    </div>

                    <div
                        class="relative rounded-xl bg-white outline outline-1 outline-gray-300 focus-within:outline-indigo-600 shadow-sm transition-all mb-4 mr-4 ml-7">
                        <label for="deskripsi" class="sr-only">Add your comment</label>
                        <textarea rows="2" name="deskripsi" id="deskripsi" x-model="form.deskripsi"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2 pr-10 text-base text-gray-900
                               shadow-sm placeholder-gray-400
                               focus:border-[#3B577D] focus:ring-2 focus:ring-[#3B577D] focus:outline-none
                               transition duration-200 ease-in-out sm:text-sm"
                            placeholder="Tambahkan Catatan..."></textarea>
                    </div>

                    {{-- Konten Alokasi Budget (tanpa chart) --}}
                    <div class="mt-6">
                        <div>
                            <h2 class="text-lg font-semibold mb-4">Alokasi Budget dari Saldo Input</h2>
                            <p class="text-gray-700 mb-5 text-s">Saldo diinput: <strong
                                    x-text="`Rp. ${form.saldo ? form.saldo.toLocaleString('id-ID') : '0'}`"></strong>
                            </p>

                            <template x-for="categoryKey in Object.keys(form.percentages)" :key="categoryKey">
                                <div class="mb-3">
                                    <label :for="categoryKey" class="text-sm text-gray-800 capitalize"
                                        x-text="categoryLabel(categoryKey)"></label>
                                    <input type="range" :id="categoryKey" :name="categoryKey"
                                        x-model.number="form.percentages[categoryKey]" min="0" max="100"
                                        class="w-full" @input="handleSliderInput(categoryKey)"
                                        :disabled="!form.saldo > 0">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600"><span
                                                x-text="form.percentages[categoryKey]"></span>%</span>
                                        <span class="text-sm text-gray-600">Rp. <span
                                                x-text="calculateMoney(categoryKey).toLocaleString('id-ID')"></span></span>
                                    </div>
                                </div>
                            </template>

                            <p class="text-sm mt-2">Sisa Persentase: <span x-text="sisaPersentase"
                                    :class="{
                                        'text-red-600': sisaPersentase < 0,
                                        /* Seharusnya tidak terjadi dengan logika baru */
                                        'text-green-600': sisaPersentase == 0 &&
                                            totalPercentage == 100
                                    }">100</span>%
                            </p>
                            <p class="text-sm font-medium"
                                :class="{
                                    'text-red-600': totalPercentage !== 100 && form.saldo >
                                        0,
                                    'text-green-600': totalPercentage === 100,
                                    'text-gray-600': totalPercentage ===
                                        0 || !form.saldo > 0
                                }">
                                Total Persentase: <span x-text="totalPercentage">0</span>%
                            </p>

                            <div class="bg-green-50 border border-green-200 text-green-800 text-xs p-2 rounded-md my-4">
                                💡 Tips : Gunakan rumus populer: 50% kebutuhan, 30% keinginan, 20% tabungan. Utang
                                disarankan <10% dari total penghasilan. </div>

                                    <div class="flex justify-center mt-6 gap-4">
                                        <button type="submit"
                                            class="inline-flex items-center rounded-md bg-[#3B577D] px-6 py-2 text-m font-semibold text-white shadow-sm hover:bg-[#4d71a3] transition-all focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-indigo-600"
                                            :disabled="!form.saldo > 0 || totalPercentage !== 100 || submitting">
                                            <span x-show="!submitting">Simpan Budgeting</span>
                                            <span x-show="submitting">Menyimpan...</span>
                                        </button>
                                        <button type="button" @click="resetAll"
                                            class="inline-flex items-center rounded-md bg-red-500 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 transition-all focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-red-600">
                                            Reset Form
                                        </button>
                                    </div>
                </form>
            </div>

            {{-- Modal dan Toast tetap ada --}}
            <div x-show="showConfirmModal" x-transition x-cloak
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                <div @click.away="showConfirmModal = false"
                    class="relative w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
                    <h2 class="text-lg font-semibold mb-4">Konfirmasi Penyimpanan</h2>
                    <p class="text-sm text-gray-600 mb-6">Apakah Anda yakin ingin menyimpan data budgeting ini?</p>
                    <div class="flex justify-end space-x-3">
                        <button @click="showConfirmModal = false"
                            class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-100">Batal</button>
                        <button @click="submitForm"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Lanjutkan</button>
                    </div>
                </div>
            </div>

            <div x-show="toast.show" x-transition x-cloak
                :class="toast.type === 'success' ? 'bg-green-600' : 'bg-red-600'"
                class="fixed top-5 right-5 z-[100] rounded-lg text-white px-4 py-2 text-sm shadow-lg">
                <span x-text="toast.message"></span>
            </div>

            <div x-show="successModal.open" x-transition x-cloak
                class="fixed inset-0 z-[90] flex items-center justify-center bg-black/50">
                <div @click.away="closeSuccessModal" class="relative w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
                    <div class="text-center">
                        <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Berhasil!</h3>
                        <p class="mt-2 text-sm text-gray-600" x-text="successModal.message"></p>
                        <button @click="closeSuccessModalAndRedirect"
                            class="mt-4 inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Selesai
                            & Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- Hapus CDN Chart.js jika tidak digunakan di tempat lain --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script>
        function budgetingApp() {
            return {
                form: {
                    saldo: null,
                    deskripsi: '',
                    percentages: {
                        kebutuhan: 0,
                        keinginan: 0,
                        tabungan: 0,
                        utang: 0,
                    }
                },
                // Properti terkait chart dihapus: chart: null, debounceChart: null,
                submitting: false,
                showConfirmModal: false,
                toast: {
                    show: false,
                    message: '',
                    type: 'success'
                },
                successModal: {
                    open: false,
                    message: ''
                },

                init() {
                    // Panggilan ke initializeChart() dan updateChart() dihapus
                    this.handleSaldoInput();
                },

                // Fungsi initializeChart() dihapus
                // Fungsi updateChart() dihapus
                // Fungsi updateChartDebounced() dihapus

                categoryLabel(categoryKey) {
                    const labels = {
                        kebutuhan: 'Kebutuhan',
                        keinginan: 'Keinginan',
                        tabungan: 'Tabungan',
                        utang: 'Utang & Credit'
                    };
                    return labels[categoryKey] || categoryKey;
                },

                get totalPercentage() {
                    return Object.values(this.form.percentages).reduce((sum, val) => sum + Number(val), 0);
                },
                get sisaPersentase() {
                    const calculatedSisa = 100 - this.totalPercentage;
                    return calculatedSisa < 0 ? 0 : calculatedSisa;
                },

                handleSaldoInput() {
                    if (this.form.saldo === null || this.form.saldo === '' || parseFloat(this.form.saldo) < 0) {
                        this.form.saldo = 0;
                    }
                    if (parseFloat(this.form.saldo) === 0) {
                        this.resetOnlyPercentages();
                    }
                    // Tidak perlu panggil updateChart() lagi
                },

                handleSliderInput(changedCategoryKey) {
                    if (this.form.percentages[changedCategoryKey] < 0) {
                        this.form.percentages[changedCategoryKey] = 0;
                    }

                    let currentSum = Object.values(this.form.percentages).reduce((sum, val) => sum + Number(val), 0);

                    if (currentSum > 100) {
                        const overflow = currentSum - 100;
                        this.form.percentages[changedCategoryKey] = Math.max(0, this.form.percentages[changedCategoryKey] -
                            overflow);
                    }
                    // Tidak perlu panggil updateChartDebounced() lagi
                },

                calculateMoney(categoryKey) {
                    const saldo = parseFloat(this.form.saldo) || 0;
                    const percentage = parseFloat(this.form.percentages[categoryKey]) || 0;
                    return (saldo * percentage) / 100;
                },

                confirmAndSubmitForm() {
                    if (!this.form.saldo || this.form.saldo <= 0) {
                        this.showToast('error', 'Masukkan nominal saldo yang valid.');
                        return;
                    }
                    if (this.totalPercentage !== 100) {
                        this.showToast('error', 'Total persentase alokasi budgeting harus 100%. Silakan sesuaikan slider.');
                        return;
                    }
                    this.showConfirmModal = true;
                },

                submitForm() {
                    this.showConfirmModal = false;
                    this.submitting = true;
                    const formData = new FormData();
                    formData.append('saldo', this.form.saldo);
                    formData.append('deskripsi', this.form.deskripsi);
                    formData.append('kebutuhan', this.form.percentages.kebutuhan);
                    formData.append('keinginan', this.form.percentages.keinginan);
                    formData.append('tabungan', this.form.percentages.tabungan);
                    formData.append('utang', this.form.percentages.utang);
                    formData.append('_token', document.querySelector('input[name="_token"]').value);

                    fetch('{{ route('tambah.saldo') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            }
                        })
                        .then(response => response.json().then(data => ({
                            ok: response.ok,
                            status: response.status,
                            body: data
                        })))
                        .then(({
                            ok,
                            status,
                            body
                        }) => {
                            if (ok && body.success) {
                                this.showSuccessModal(body.message || 'Budgeting berhasil disimpan!');
                            } else {
                                this.showToast('error', body.message || `Terjadi kesalahan (HTTP ${status})`);
                            }
                        })
                        .catch(error => {
                            console.error('Fetch Error:', error);
                            this.showToast('error', 'Tidak dapat terhubung ke server. Silakan coba lagi.');
                        })
                        .finally(() => {
                            this.submitting = false;
                        });
                },
                resetOnlyPercentages() {
                    this.form.percentages.kebutuhan = 0;
                    this.form.percentages.keinginan = 0;
                    this.form.percentages.tabungan = 0;
                    this.form.percentages.utang = 0;
                    // Tidak perlu panggil updateChart() lagi
                },
                resetFormValues() {
                    this.form.saldo = null;
                    this.form.deskripsi = '';
                    this.resetOnlyPercentages();
                },
                resetAll() {
                    this.resetFormValues();
                },

                showToast(type, message) {
                    this.toast.type = type;
                    this.toast.message = message;
                    this.toast.show = true;
                    setTimeout(() => this.toast.show = false, 3000);
                },

                showSuccessModal(message) {
                    this.successModal.message = message;
                    this.successModal.open = true;
                },
                closeSuccessModal() {
                    this.successModal.open = false;
                    this.resetFormValues();
                },
                closeSuccessModalAndRedirect() {
                    this.successModal.open = false;
                    this.resetFormValues();
                    window.location.reload();
                }
            };
        }
    </script>
</x-app-layout>
