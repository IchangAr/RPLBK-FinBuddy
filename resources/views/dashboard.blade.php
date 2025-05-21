<x-app-layout>
    <main class="py-1">
        <div class="px-4 sm:px-6 lg:px-8">
            <div>
                <h1 class="text-xl ">Selamat datang di</h1>
                <h2 class="ml-8 text-5xl font-bold">FinBuddy</h2>
                <p class="text-sm text-gray-600 ml-2">Siap Mengola Keuangan Anda</p>
            </div>
            <div class="grid grid-cols-5 md:grid-cols-1 gap-6 mt-6">
                <!-- Saldo Section (Dummy Data) -->
                <div class="bg-white p-4 rounded-md shadow flex flex-col justify-between h-full">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-2">
                        <p class="text-xs text-gray-600">Saldo Anda Saat Ini:</p>
                        <span class="text-sm font-semibold">Rp
                            {{ number_format(1000000, 0, ',', '.') }}</span>
                    </div>

                    <!-- Saldo Besar -->
                    <div class="text-2xl font-bold  mb-4">
                        Rp {{ number_format(1000000, 0, ',', '.') }}
                    </div>

                    <!-- Progress Bar Tabungan -->
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-1">Target Tabungan: Rp 5.000.000</p>
                        <div class="w-full bg-gray-200 h-2 rounded-full">
                            <div class="bg-[#3B577D] h-2 rounded-full" style="width: 20%"></div>
                        </div>
                    </div>

                    <!-- Ringkasan Pemasukan / Pengeluaran -->
                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-600 mb-4">
                        <div class="bg-gray-50 p-2 rounded-md">
                            <p class="font-semibold text-gray-800">Pemasukan</p>
                            <p class="font-bold">Rp 3.000.000</p>
                        </div>
                        <div class="bg-gray-50 p-2 rounded-md">
                            <p class="font-semibold text-gray-800">Pengeluaran</p>
                            <p class="font-bold">Rp 2.500.000</p>
                        </div>
                    </div>

                    <!-- Tips -->
                    <div class="bg-green-50 border border-green-200 text-green-800 text-xs p-2 rounded-md mb-4">
                        💡 Tips: Sisihkan minimal 20% dari saldo untuk dana darurat.
                    </div>

                    <!-- Aksi Cepat -->
                    <div class="flex gap-2">
                        <a href="budgeting" class="bg-[#3B577D] hover:bg-[#4d71a3] text-white text-xs px-3 py-3 rounded-md w-full">
                            + Tambah Pemasukan
                        </a>
                        <a href="pengeluaran" class="bg-[#7f9098] hover:bg-[#545f65] text-white text-xs px-3 py-3 rounded-md w-full">
                            + Tambah Pengeluaran
                        </a>
                    </div>
                </div>
            </div>


            <div class="bg-white p-6 rounded-md shadow mt-4">
                <h2 class="text-lg font-semibold mb-4 ">Perbandingan Pengeluaran dengan Budget</h2>
                <div class="flex justify-center items-center">
                    <canvas id="pieChart" width="230" height="230"></canvas>
                </div>
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Pengeluaran vs Budget',
                    data: {!! json_encode($data) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)', // warna untuk pengeluaran
                        'rgba(54, 162, 235, 0.7)' // warna untuk budget
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false, // penting agar ukuran canvas tidak di-override
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                    }
                }
            }
        });
    </script>
</x-app-layout>
