<x-app-layout>
    <main class="py-1">
        <div class="px-4 sm:px-6 lg:px-8">
            <div>
                <h1 class="text-xl">Selamat datang di</h1>
                <h2 class="ml-8 text-5xl font-bold">FinBuddy</h2>
                <p class="text-sm text-gray-600 ml-2">Siap Mengola Keuangan Anda</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mt-6">
                <div class="bg-white p-4 rounded-md shadow flex flex-col justify-between h-full">
                    <div class="text-2xl font-bold mb-4">
                        Rp {{ number_format($totalSaldo, 0, ',', '.') }}
                    </div>
                    @php
                        $sisaTabungan = max(0, $totalTabungan - $pengeluaranTabungan);
                        $persenSisa = $totalTabungan > 0 ? ($sisaTabungan / $totalTabungan) * 100 : 0;
                    @endphp
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-1">
                            Sisa Tabungan: Rp {{ number_format($sisaTabungan, 0, ',', '.') }} dari Rp
                            {{ number_format($totalTabungan, 0, ',', '.') }}
                        </p>
                        <div class="w-full bg-gray-200 h-2 rounded-full">
                            <div class="bg-[#3B577D] h-2 rounded-full" style="width: {{ $persenSisa }}%"></div>
                        </div>
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
                    <div class="bg-green-50 border border-green-200 text-green-800 text-xs p-2 rounded-md mb-4">
                        💡 Gunakan Aplikasi Keuangan FinBuddy! Untuk pantau pemasukan, pengeluaran, dan saldo langsung
                        dari satu dashboard.
                    </div>
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
                <h2 class="text-sm font-semibold text-gray-700 mb-4">Tren Keuangan Harian (30 Hari Terakhir)</h2>
                <div class="flex justify-center">
                    <canvas id="lineChartPengeluaranPemasukan" width="600" height="300"></canvas>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dates = @json($dates);
            const pemasukan = @json($pemasukanData);
            const pengeluaran = @json($pengeluaranData);

            // Line Chart: Pemasukan vs Pengeluaran Harian
            const ctxPengeluaranPemasukan = document.getElementById('lineChartPengeluaranPemasukan').getContext('2d');
            new Chart(ctxPengeluaranPemasukan, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [
                        {
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
                            text: 'Pemasukan vs Pengeluaran Harian'
                        },
                        tooltip: {
                            callbacks: {
                                title: function(tooltipItems) {
                                    return tooltipItems[0].label; // Menampilkan tanggal di tooltip
                                },
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Tanggal'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Nominal (Rp)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
