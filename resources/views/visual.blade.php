<x-app-layout>
    <main class="py-2">
        <div class="px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div>
                <h1 class="text-3xl font-bold leading-tight">Visualisasi Keuangan Anda</h1>
                <p class="ml-8 text-sm text-gray-600 leading-tight mb-1">Siap mengelola keuangan anda dengan lebih baik.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Saldo Section -->
                <div class="bg-white p-6 rounded-2xl shadow-md flex flex-col justify-between h-full transition hover:shadow-lg">
                    <div class="flex justify-between items-center mb-2">
                        <p class="text-sm text-gray-500">Saldo Anda Saat Ini</p>
                    </div>
                    <div class="text-3xl font-bold text-[#3B577D] mb-6">
                        Rp {{ number_format($totalSaldo, 0, ',', '.') }}
                    </div>
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
                    <div class="bg-green-50 border border-green-200 text-green-800 text-xs p-3 rounded-lg mb-2">
                        💡 <strong>Tips:</strong> Jangan lupa selalu catat pengeluaran kamu
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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-8">
                <div class="bg-white p-4 rounded-md shadow">
                    <h3 class="text-lg font-semibold text-gray-600 text-center">Kebutuhan</h3>
                    <canvas id="pieChartKebutuhan" width="150" height="150"></canvas>
                </div>
                <div class="bg-white p-4 rounded-md shadow">
                    <h3 class="text-lg font-semibold text-gray-600 text-center">Keinginan</h3>
                    <canvas id="pieChartKeinginan" width="150" height="150"></canvas>
                </div>
                <div class="bg-white p-4 rounded-md shadow">
                    <h3 class="text-lg font-semibold text-gray-600 text-center">Tabungan</h3>
                    <canvas id="pieChartTabungan" width="150" height="150"></canvas>
                </div>
                <div class="bg-white p-4 rounded-md shadow">
                    <h3 class="text-lg font-semibold text-gray-600 text-center">Utang</h3>
                    <canvas id="pieChartUtang" width="150" height="150"></canvas>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Data untuk bar chart
            const months = @json($months);
            const pemasukan = @json($pemasukanData);
            const pengeluaran = @json($pengeluaranData);

            // Bar chart Pemasukan vs Pengeluaran
            const ctxBar = document.getElementById('barChartPengeluaranPemasukan').getContext('2d');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Pemasukan',
                        data: pemasukan,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Pengeluaran',
                        data: pengeluaran,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        title: { display: true, text: 'Pemasukan vs Pengeluaran' }
                    }
                }
            });

            // Data untuk pie chart
            const kategoriData = @json($kategoriData);
            console.log('Data kategori:', kategoriData); // Debugging

            // Fungsi untuk membuat pie chart dengan error handling
            function buatPieChart(idCanvas, labelKategori, pengeluaran, budget, warna1, warna2) {
                if (!document.getElementById(idCanvas)) {
                    console.error(`Canvas dengan ID ${idCanvas} tidak ditemukan.`);
                    return;
                }

                // Validasi data
                const pengeluaranVal = Number(pengeluaran) || 0;
                const budgetVal = Number(budget) || 0;

                if (pengeluaranVal < 0 || budgetVal < 0) {
                    console.warn(`Data tidak valid untuk ${labelKategori}: pengeluaran=${pengeluaranVal}, budget=${budgetVal}`);
                    return;
                }

                const ctx = document.getElementById(idCanvas).getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Pengeluaran', 'Sisa Budget'],
                        datasets: [{
                            label: labelKategori,
                            data: [pengeluaranVal, budgetVal],
                            backgroundColor: [warna1, warna2],
                            borderColor: [warna1.replace('0.7', '1'), warna2.replace('0.7', '1')],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' },
                            title: { display: true, text: labelKategori }
                        }
                    }
                });
            }

            // Inisialisasi pie chart
            const charts = [
                { id: 'pieChartKebutuhan', kategori: 'kebutuhan', label: 'Kebutuhan', warna1: 'rgba(255, 99, 132, 0.7)', warna2: 'rgba(54, 162, 235, 0.7)' },
                { id: 'pieChartKeinginan', kategori: 'keinginan', label: 'Keinginan', warna1: 'rgba(255, 159, 64, 0.7)', warna2: 'rgba(75, 192, 192, 0.7)' },
                { id: 'pieChartTabungan', kategori: 'tabungan', label: 'Tabungan', warna1: 'rgba(153, 102, 255, 0.7)', warna2: 'rgba(255, 159, 64, 0.7)' },
                { id: 'pieChartUtang', kategori: 'utang', label: 'Utang', warna1: 'rgba(54, 162, 235, 0.7)', warna2: 'rgba(75, 192, 192, 0.7)' }
            ];

            charts.forEach(chart => {
                if (kategoriData[chart.kategori]) {
                    buatPieChart(
                        chart.id,
                        chart.label,
                        kategoriData[chart.kategori].pengeluaran,
                        kategoriData[chart.kategori].budget,
                        chart.warna1,
                        chart.warna2
                    );
                } else {
                    console.warn(`Data untuk kategori ${chart.kategori} tidak tersedia.`);
                }
            });
        });
    </script>
</x-app-layout>
