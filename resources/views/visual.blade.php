<x-app-layout>
    <main class="py-10">
        <div class="px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div>
<<<<<<< HEAD
                <h1 class="text-xl font-semibold">Visualisasi Keuangan Anda</h1>
                <p class="mt-2 text-gray-600">Siap mengelola keuangan anda dengan lebih baik.</p>
=======
                <h1 class="text-3xl font-bold leading-tight">Visualisasi Keuangan Anda</h1>
                <p class="ml-8 text-sm text-gray-600 leading-tight mb-1">Siap mengelola keuangan anda dengan lebih baik.
                </p>
>>>>>>> a9ed1f0ee3938a5a597678541af28470e5d88d3c
            </div>

            <!-- Saldo dan Pemasukan vs Pengeluaran per Bulan (Sampingan) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Saldo Section (Dummy Data) -->
                <div class="bg-white p-4 rounded-md shadow flex flex-col justify-between h-full">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-2">
                        <p class="text-xs text-gray-600">Saldo Anda Saat Ini:</p>
<<<<<<< HEAD
                        <span class="text-sm font-semibold text-green-600">Rp
=======
                        <span class="text-sm font-semibold">Rp
>>>>>>> a9ed1f0ee3938a5a597678541af28470e5d88d3c
                            {{ number_format(1000000, 0, ',', '.') }}</span>
                    </div>

                    <!-- Saldo Besar -->
<<<<<<< HEAD
                    <div class="text-2xl font-bold text-green-600 mb-4">
=======
                    <div class="text-2xl font-bold  mb-4">
>>>>>>> a9ed1f0ee3938a5a597678541af28470e5d88d3c
                        Rp {{ number_format(1000000, 0, ',', '.') }}
                    </div>

                    <!-- Progress Bar Tabungan -->
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-1">Target Tabungan: Rp 5.000.000</p>
                        <div class="w-full bg-gray-200 h-2 rounded-full">
<<<<<<< HEAD
                            <div class="bg-green-500 h-2 rounded-full" style="width: 20%"></div>
=======
                            <div class="bg-[#3B577D] h-2 rounded-full" style="width: 20%"></div>
>>>>>>> a9ed1f0ee3938a5a597678541af28470e5d88d3c
                        </div>
                    </div>

                    <!-- Ringkasan Pemasukan / Pengeluaran -->
                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-600 mb-4">
                        <div class="bg-gray-50 p-2 rounded-md">
                            <p class="font-semibold text-gray-800">Pemasukan</p>
<<<<<<< HEAD
                            <p class="text-green-500 font-bold">Rp 3.000.000</p>
                        </div>
                        <div class="bg-gray-50 p-2 rounded-md">
                            <p class="font-semibold text-gray-800">Pengeluaran</p>
                            <p class="text-red-500 font-bold">Rp 2.500.000</p>
=======
                            <p class="font-bold">Rp 3.000.000</p>
                        </div>
                        <div class="bg-gray-50 p-2 rounded-md">
                            <p class="font-semibold text-gray-800">Pengeluaran</p>
                            <p class="font-bold">Rp 2.500.000</p>
>>>>>>> a9ed1f0ee3938a5a597678541af28470e5d88d3c
                        </div>
                    </div>

                    <!-- Tips -->
                    <div class="bg-green-50 border border-green-200 text-green-800 text-xs p-2 rounded-md mb-4">
                        💡 Tips: Sisihkan minimal 20% dari saldo untuk dana darurat.
                    </div>

                    <!-- Aksi Cepat -->
                    <div class="flex gap-2">
<<<<<<< HEAD
                        <button class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded-md w-full">
                            + Tambah Pemasukan
                        </button>
                        <button class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded-md w-full">
=======
                        <button class="bg-[#3B577D] hover:bg-[#4d71a3] text-white text-xs px-3 py-1 rounded-md w-full">
                            + Tambah Pemasukan
                        </button>
                        <button class="bg-[#7f9098] hover:bg-[#545f65] text-white text-xs px-3 py-1 rounded-md w-full">
>>>>>>> a9ed1f0ee3938a5a597678541af28470e5d88d3c
                            + Tambah Pengeluaran
                        </button>
                    </div>
                </div>

                <!-- Pemasukan vs Pengeluaran per Bulan (Bar Chart) -->
                <div class="bg-white p-4 rounded-md shadow">
                    <h2 class="text-sm font-semibold mb-4">Pemasukan vs Pengeluaran per Bulan</h2>
                    <div class="flex justify-center items-center">
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
