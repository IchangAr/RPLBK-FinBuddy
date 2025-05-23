<x-app-layout>
    <main class="py-1">
        <div class="px-4 sm:px-6 lg:px-8">
            <div>
                <h1 class="text-xl ">Selamat datang di</h1>
                <h2 class="ml-8 text-5xl font-bold">FinBuddy</h2>
                <p class="text-sm text-gray-600 ml-2">Siap Mengola Keuangan Anda</p>
            </div>
            <div class="grid grid-cols-5 md:grid-cols-1 gap-6 mt-6">
                <div class="bg-white p-4 rounded-md shadow flex flex-col justify-between h-full">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-2">
                     
                    </div>

                    <!-- Saldo Besar -->
                    <div class="text-2xl font-bold  mb-4">
                        Rp {{ number_format($totalSaldo, 0, ',', '.') }}
                    </div>

                    <!-- Progress Bar Tabungan -->
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-1">Tabungan: Rp {{ number_format(100000, 0, ',', '.') }}</p>
                        <div class="w-full bg-gray-200 h-2 rounded-full">
                            <div class="bg-[#3B577D] h-2 rounded-full" style="width: 20%"></div>
                        </div>
                    </div>

                    <!-- Ringkasan Pemasukan / Pengeluaran -->
                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-700 mb-6">
                        <div class="bg-gray-50 p-3 rounded-xl shadow-inner">
                            <p class="font-semibold text-gray-600">Pemasukan</p>
                            <p class="font-bold text-green-600">Rp {{ number_format($user->saldo, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-xl shadow-inner">
                            <p class="font-semibold text-gray-600">Pengeluaran</p>
                            <p class="font-bold text-red-600">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <!-- Tips -->
                    <div class="bg-green-50 border border-green-200 text-green-800 text-xs p-2 rounded-md mb-4">
                        💡 Gunakan Aplikasi Keuangan FinBuddy! Untuk pantau pemasukan, pengeluaran, dan saldo langsung dari satu dashboard.
                    </div>

                    <!-- Aksi Cepat -->
                    <div class="flex gap-2">
                        <a href="budgeting"
                            class="bg-[#3B577D] hover:bg-[#4d71a3] text-white text-xs px-3 py-3 rounded-md w-full">
                            + Tambah Pemasukan
                        </a>
                        <a href="pengeluaran"
                            class="bg-[#7f9098] hover:bg-[#545f65] text-white text-xs px-3 py-3 rounded-md w-full">
                            + Tambah Pengeluaran
                        </a>
                    </div>
                </div>
            </div>


            <div class="mt-8 bg-white p-6 rounded-2xl shadow-md">
    <h2 class="text-sm font-semibold text-gray-700 mb-4">Tren Saldo Bulanan</h2>
    <div class="flex justify-center">
        <canvas id="lineChartPengeluaranPemasukan" width="600" height="300"></canvas>
    </div>
</div>


        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const months = @json($months);
        const pemasukan = @json($pemasukanData);
        const pengeluaran = @json($pengeluaranData);
        // const saldoBulanan = @json($saldoBulanan);
        // const totalPengeluaran = @json($totalPengeluaran);

        // Line Chart: Pemasukan vs Pengeluaran
        const ctxPengeluaranPemasukan = document.getElementById('lineChartPengeluaranPemasukan').getContext('2d');
        new Chart(ctxPengeluaranPemasukan, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                        label: 'Pemasukan',
                        data: pemasukan,
                        fill: false,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        tension: 0.4
                    },
                    {
                        label: 'Pengeluaran',
                        data: pengeluaran,
                        fill: false,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Pemasukan vs Pengeluaran Bulanan'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>


</x-app-layout>
