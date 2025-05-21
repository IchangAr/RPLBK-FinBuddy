<x-app-layout>
    <main class="py-10">
        <div class="px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div>
                <h1 class="text-3xl font-bold leading-tight">Visualisasi Keuangan Anda</h1>
                <p class="ml-8 text-sm text-gray-600 leading-tight mb-1">Siap mengelola keuangan anda dengan lebih baik.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <!-- Saldo Section -->
    <div class="bg-white p-6 rounded-2xl shadow-md flex flex-col justify-between h-full transition hover:shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-2">
            <p class="text-sm text-gray-500">Saldo Anda Saat Ini</p>

        </div>

        <!-- Saldo Besar -->
        <div class="text-3xl font-bold text-[#3B577D] mb-6">
            Rp {{ number_format(1000000, 0, ',', '.') }}
        </div>

        <!-- Progress Bar Tabungan -->
        <div class="mb-6">
            <p class="text-xs text-gray-500 mb-1">Target Tabungan: Rp 5.000.000</p>
            <div class="w-full bg-gray-200 h-3 rounded-full overflow-hidden">
                <div class="bg-[#3B577D] h-3 rounded-full transition-all duration-500" style="width: 20%"></div>
            </div>
        </div>

        <!-- Ringkasan Pemasukan / Pengeluaran -->
        <div class="grid grid-cols-2 gap-4 text-sm text-gray-700 mb-6">
            <div class="bg-gray-50 p-3 rounded-xl shadow-inner">
                <p class="font-semibold text-gray-600">Pemasukan</p>
                <p class="font-bold text-green-600">Rp 3.000.000</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-xl shadow-inner">
                <p class="font-semibold text-gray-600">Pengeluaran</p>
                <p class="font-bold text-red-600">Rp 2.500.000</p>
            </div>
        </div>

        <!-- Tips -->
        <div class="bg-green-50 border border-green-200 text-green-800 text-xs p-3 rounded-lg mb-2">
            💡 <strong>Tips:</strong> Sisihkan minimal 20% dari saldo untuk dana darurat.
        </div>
    </div>

    <!-- Pemasukan vs Pengeluaran per Bulan (Bar Chart) -->
    <div class="bg-white p-6 rounded-2xl shadow-md h-full flex flex-col justify-between transition hover:shadow-lg">
        <h2 class="text-sm font-semibold text-gray-700 mb-4">Pemasukan vs Pengeluaran per Bulan</h2>
        <div class="flex-grow flex justify-center items-center">
            <canvas id="barChartPengeluaranPemasukan" width="400" height="200"></canvas>
        </div>
    </div>
</div>

            <!-- Tabel dengan 4 Pie Charts -->
            <div class="grid grid-cols-4 gap-2 mt-8">
                <!-- Pie Chart 1 -->
                <div class="bg-white p-4 rounded-md shadow">
                    <h3 class="text-L font-semibold text-gray-600 text-center">Kebutuhan</h3>
                    <canvas id="pieChartMakanan" width="150" height="150"></canvas>
                </div>
                <!-- Pie Chart 2 -->
                <div class="bg-white p-4 rounded-md shadow">
                    <h2 class="text-L font-semibold text-gray-600 text-center">Keinginan</h2>
                    <canvas id="pieChartTransportasi" width="150" height="150"></canvas>
                </div>
                <!-- Pie Chart 3 -->
                <div class="bg-white p-4 rounded-md shadow">
                    <h3 class="text-L font-semibold text-gray-600 text-center">Tabungan</h3>
                    <canvas id="pieChartHiburan" width="150" height="150"></canvas>
                </div>
                <!-- Pie Chart 4 -->
                <div class="bg-white p-4 rounded-md shadow">
                    <h3 class="text-L font-semibold text-gray-600 text-center">Utang atau Credit</h3>
                    <canvas id="pieChartLainnya" width="150" height="150"></canvas>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data dummy untuk pemasukan dan pengeluaran per bulan
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const pemasukan = [2000000, 2500000, 3000000, 2700000, 3200000, 3100000, 3500000, 3300000, 3800000, 4000000,
            4500000, 5000000
        ]; // Pemasukan tiap bulan
        const pengeluaran = [1500000, 2000000, 2500000, 2200000, 2800000, 2600000, 3000000, 2900000, 3400000, 3600000,
            4000000, 4500000
        ]; // Pengeluaran tiap bulan

        // Bar Chart Pemasukan vs Pengeluaran per Bulan
        const ctxPengeluaranPemasukan = document.getElementById('barChartPengeluaranPemasukan').getContext('2d');
        const barChartPengeluaranPemasukan = new Chart(ctxPengeluaranPemasukan, {
            type: 'bar',
            data: {
                labels: months, // Bulan-bulan
                datasets: [{
                        label: 'Pemasukan',
                        data: pemasukan,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)', // Warna untuk Pemasukan
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Pengeluaran',
                        data: pengeluaran,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)', // Warna untuk Pengeluaran
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Pemasukan vs Pengeluaran per Bulan'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Jumlah (Rp)'
                        },
                        beginAtZero: true
                    }
                }
            }
        });

        // Pie chart Makanan
        const ctxMakanan = document.getElementById('pieChartMakanan').getContext('2d');
        const pieChartMakanan = new Chart(ctxMakanan, {
            type: 'pie',
            data: {
                labels: ['Pengeluaran', 'Budget'],
                datasets: [{
                    label: 'Makanan',
                    data: [500000, 600000],
                    backgroundColor: ['rgba(255, 99, 132, 0.7)', 'rgba(54, 162, 235, 0.7)'],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Makanan'
                    }
                }
            }
        });

        // Pie chart Transportasi
        const ctxTransportasi = document.getElementById('pieChartTransportasi').getContext('2d');
        const pieChartTransportasi = new Chart(ctxTransportasi, {
            type: 'pie',
            data: {
                labels: ['Pengeluaran', 'Budget'],
                datasets: [{
                    label: 'Transportasi',
                    data: [150000, 200000],
                    backgroundColor: ['rgba(255, 159, 64, 0.7)', 'rgba(75, 192, 192, 0.7)'],
                    borderColor: ['rgba(255, 159, 64, 1)', 'rgba(75, 192, 192, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Transportasi'
                    }
                }
            }
        });

        // Pie chart Hiburan
        const ctxHiburan = document.getElementById('pieChartHiburan').getContext('2d');
        const pieChartHiburan = new Chart(ctxHiburan, {
            type: 'pie',
            data: {
                labels: ['Pengeluaran', 'Budget'],
                datasets: [{
                    label: 'Hiburan',
                    data: [100000, 120000],
                    backgroundColor: ['rgba(153, 102, 255, 0.7)', 'rgba(255, 159, 64, 0.7)'],
                    borderColor: ['rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Hiburan'
                    }
                }
            }
        });

        // Pie chart Lainnya
        const ctxLainnya = document.getElementById('pieChartLainnya').getContext('2d');
        const pieChartLainnya = new Chart(ctxLainnya, {
            type: 'pie',
            data: {
                labels: ['Pengeluaran', 'Budget'],
                datasets: [{
                    label: 'Lainnya',
                    data: [70000, 50000],
                    backgroundColor: ['rgba(54, 162, 235, 0.7)', 'rgba(75, 192, 192, 0.7)'],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(75, 192, 192, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Lainnya'
                    }
                }
            }
        });
    </script>
</x-app-layout>
