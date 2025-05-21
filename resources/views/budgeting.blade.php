<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<x-app-layout>
    <main class="py-2">
        <div class="px-4 sm:px-6 lg:px-8">
            <div>
                <h1 class="ml-8 text-5xl font-bold">Budgeting</h1>
                <p class="text-sm text-gray-600 ml-2">Kelola Keuanganmu yuuuk!</p>
            </div>

            <!-- Form Gabungan untuk Tambah Saldo dan Komentar -->
            <div class="mt-6 bg-white p-6 rounded-md shadow">
                <h2 class="text-lg font-semibold mb-4">Tambah Saldo</h2>
                <form action="{{ route('tambah.saldo') }}" method="POST" id="form-budgeting">

                    @if (session('success'))
                        <div x-data="{ open: true }" x-show="open" x-transition>
                            @include('components.modal-success')
                        </div>
                    @endif
                    @csrf

                    <!-- Input Saldo -->
                    <div class="flex items-center gap-3 mb-4">
                        <label for="saldo" class="text-sm text-gray-600 whitespace-nowrap">Rp</label>
                        <input type="number" name="saldo" id="saldo"
                            class="border rounded-md px-2 py-1 text-sm w-full mr-4" placeholder="Masukkan saldo"
                            required>
                    </div>

                    <!-- Komentar -->
                    <div
                        class="relative rounded-xl bg-white outline outline-1 outline-gray-300 focus-within:outline-indigo-600 shadow-sm transition-all mb-4 mr-4 ml-7">
                        <label for="deskripsi" class="sr-only">Add your comment</label>
                        <textarea rows="2" name="deskripsi" id="deskripsi"
                            class="block w-full resize-none bg-transparent px-3 py-2 text-xs text-gray-800 placeholder-gray-400 border-none outline-none ring-0 focus:outline-none focus:ring-0 focus:border-none"
                            placeholder="Tambahkan Catatan..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Form Budgeting -->
                        <div>
                            <h2 class="text-lg font-semibold mb-4">Saldo yang siap kamu budgeting</h2>
                            <p id="display-saldo" class="text-gray-700 mb-5 text-s">Rp. -</p>

                            <!-- Slider untuk Kebutuhan, Keinginan, Tabungan, dan Utang -->
                            <div class="mb-3">
                                <label for="kebutuhan" class="text-sm text-gray-800">Kebutuhan</label>
                                <input type="range" id="kebutuhan" name="kebutuhan" min="0" max="100"
                                    value="0" class="w-full" oninput="updateValue('kebutuhan')" disabled>
                                <div class="flex justify-between">
                                    <span id="kebutuhan-value" class="text-sm text-gray-600">0%</span>
                                    <span id="kebutuhan-money" class="text-sm text-gray-600">Rp. 0</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="keinginan" class="text-sm text-gray-800">Keinginan</label>
                                <input type="range" id="keinginan" name="keinginan" min="0" max="100"
                                    value="0" class="w-full" oninput="updateValue('keinginan')" disabled>
                                <div class="flex justify-between">
                                    <span id="keinginan-value" class="text-sm text-gray-600">0%</span>
                                    <span id="keinginan-money" class="text-sm text-gray-600">Rp. 0</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="tabungan" class="text-sm text-gray-800">Tabungan</label>
                                <input type="range" id="tabungan" name="tabungan" min="0" max="100"
                                    value="0" class="w-full" oninput="updateValue('tabungan')" disabled>
                                <div class="flex justify-between">
                                    <span id="tabungan-value" class="text-sm text-gray-600">0%</span>
                                    <span id="tabungan-money" class="text-sm text-gray-600">Rp. 0</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="utang" class="text-sm text-gray-800">Utang & Credit</label>
                                <input type="range" id="utang" name="utang" min="0" max="100"
                                    value="0" class="w-full" oninput="updateValue('utang')" disabled>
                                <div class="flex justify-between">
                                    <span id="utang-value" class="text-sm text-gray-600">0%</span>
                                    <span id="utang-money" class="text-sm text-gray-600">Rp. 0</span>
                                </div>
                            </div>

                            <p class="text-sm text-gray-600">Sisa Persentase: <span id="sisa-persentase">100%</span></p>

                            <div class="bg-green-50 border border-green-200 text-green-800 text-xs p-2 rounded-md mb-4">
                                💡 Tips: Sisihkan minimal 20% dari saldo untuk tabungan.
                            </div>

                            <input type="hidden" name="kebutuhan" id="hidden-kebutuhan">
                            <input type="hidden" name="keinginan" id="hidden-keinginan">
                            <input type="hidden" name="tabungan" id="hidden-tabungan">
                            <input type="hidden" name="utang" id="hidden-utang">



                        </div>

                        <!-- Chart Bar -->
                        <div>
                            <h2 class="text-lg font-semibold mb-4">Pembagian Budgeting</h2>
                            <canvas id="budgetBarChart" width="200" height="200"></canvas>
                        </div>
                    </div>
                    <div class="flex justify-center mt-6 gap-4">
                        <button type="submit"
                            class="inline-flex items-center rounded-md bg-[#3B577D] px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-[#4d71a3] transition-all focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-indigo-600"
                            disabled>
                            Simpan
                        </button>
                        <button type="button" onclick="resetBudgeting()"
                            class="inline-flex items-center rounded-md bg-red-500 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-red-600 transition-all focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-indigo-600">
                            Reset Budgeting
                        </button>
                    </div>


                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Mendapatkan elemen dari DOM
        const saldoInput = document.getElementById('saldo');
        const displaySaldo = document.getElementById('display-saldo');
        const sisaPersentaseDisplay = document.getElementById('sisa-persentase');
        const sliders = document.querySelectorAll('input[type="range"]');
        const submitButton = document.querySelector('button[type="submit"]');

        // Inisialisasi Chart.js untuk Bar Chart
        const ctx = document.getElementById('budgetBarChart').getContext('2d');
        const budgetBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Kebutuhan', 'Keinginan', 'Tabungan', 'Utang'],
                datasets: [{
                    label: 'Alokasi Budgeting',
                    data: [0, 0, 0, 0], // Data awal
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                    borderColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });

        // Fungsi untuk memperbarui nilai input slider
        function updateValue(id) {
            const slider = document.getElementById(id);
            const valueDisplay = document.getElementById(`${id}-value`);
            const moneyDisplay = document.getElementById(`${id}-money`);
            const hiddenInput = document.getElementById(`hidden-${id}`);

            const persen = parseInt(slider.value) || 0;
            const saldo = parseFloat(saldoInput.value) || 0;
            const money = (saldo * persen) / 100;

            // Tampilkan persentase dan uang
            valueDisplay.textContent = `${persen}%`;
            moneyDisplay.textContent = `Rp. ${money.toLocaleString('id-ID')}`;

            // Simpan ke input hidden
            if (hiddenInput) {
                hiddenInput.value = persen;
            }

            // Hitung total persen
            const totalPersen = getTotalPercentage();
            const sisaPersen = 100 - totalPersen;
            sisaPersentaseDisplay.textContent = `${sisaPersen}%`;

            // Nonaktifkan slider jika sudah penuh 100%
            if (totalPersen >= 100) {
                disableSliders();
            } else {
                enableSliders();
            }

            // Perbarui Chart
            updateChartData();
        }

        // Fungsi untuk mendapatkan total persen
        function getTotalPercentage() {
            const kebutuhan = parseInt(document.getElementById('kebutuhan').value) || 0;
            const keinginan = parseInt(document.getElementById('keinginan').value) || 0;
            const tabungan = parseInt(document.getElementById('tabungan').value) || 0;
            const utang = parseInt(document.getElementById('utang').value) || 0;
            return kebutuhan + keinginan + tabungan + utang;
        }

        // Fungsi untuk memperbarui data chart
        function updateChartData() {
            const kebutuhan = parseInt(document.getElementById('kebutuhan').value) || 0;
            const keinginan = parseInt(document.getElementById('keinginan').value) || 0;
            const tabungan = parseInt(document.getElementById('tabungan').value) || 0;
            const utang = parseInt(document.getElementById('utang').value) || 0;

            budgetBarChart.data.datasets[0].data = [kebutuhan, keinginan, tabungan, utang];
            budgetBarChart.update();
        }

        // Fungsi untuk menonaktifkan slider
        function disableSliders() {
            sliders.forEach(slider => {
                slider.disabled = true;
            });
        }

        // Fungsi untuk mengaktifkan slider
        function enableSliders() {
            sliders.forEach(slider => {
                slider.disabled = false;
            });
        }

        // Fungsi untuk mereset budgeting
        function resetBudgeting() {
            // Menyimpan nilai saldo sebelumnya sebelum reset
            const previousSaldo = parseFloat(saldoInput.value);

            // Reset semua slider ke 0
            document.querySelectorAll('input[type="range"]').forEach(slider => {
                slider.value = 0;
            });

            // Reset label persentase dan uang terkait dengan slider ke 0
            document.querySelectorAll('.text-sm.text-gray-600').forEach(span => {
                if (span.id.includes('-value') || span.id.includes('-money')) {
                    span.textContent = "0%";
                }
            });

            // Reset sisa persentase
            sisaPersentaseDisplay.textContent = "100%";

            // Reset chart data
            budgetBarChart.data.datasets[0].data = [0, 0, 0, 0];
            budgetBarChart.update();

            // Kembalikan saldo ke nilai sebelumnya
            if (!isNaN(previousSaldo)) {
                saldoInput.value = previousSaldo;
                updateSaldoDisplay();
            }

            // Aktifkan kembali slider jika sebelumnya sudah dinonaktifkan
            enableSliders();
        }

        // Event listener untuk input saldo
        saldoInput.addEventListener('input', updateSaldoDisplay);

        // Fungsi untuk memperbarui saldo yang ditampilkan
        function updateSaldoDisplay() {
            const saldo = parseFloat(saldoInput.value);
            if (!isNaN(saldo)) {
                displaySaldo.textContent = `Rp. ${saldo.toLocaleString()}`;
                enableSliders(); // Mengaktifkan slider jika saldo terinput
                submitButton.disabled = false; // Mengaktifkan tombol submit jika saldo ada
            } else {
                displaySaldo.textContent = "Rp. -";
                disableSliders(); // Menonaktifkan slider jika saldo belum ada
                submitButton.disabled = true; // Menonaktifkan tombol submit jika saldo belum ada
            }
        }
    </script>
</x-app-layout>
