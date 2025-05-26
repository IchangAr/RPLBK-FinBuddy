<x-app-layout>
    <main class="py-1">
        <div class="px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4"
                    role="alert">
                    <strong class="font-bold">Sukses!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            <div>
                <h1 class="text-xl">Selamat datang di</h1>
                <h2 class="ml-8 text-5xl font-bold">FinBuddy</h2>
                <p class="text-sm text-gray-600 ml-2">Siap Mengola Keuangan Anda</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mt-6">
                <div class="mt-6 p-6 bg-white bg-opacity-70 backdrop-blur-md rounded-md shadow-md">
                    <p class="text-sm text-gray-500">Saldo Anda Saat Ini</p>
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
                            <p class="font-bold text-green-600">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
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

            <div class="mt-6 p-6 bg-white bg-opacity-70 backdrop-blur-md rounded-md shadow-md">
                <h2 class="text-sm font-semibold text-gray-700 mb-4">Tren Keuangan Harian (30 Hari Terakhir)</h2>
                <div class="flex justify-center">
                    <canvas id="lineChartPengeluaranPemasukan" width="600" height="300"></canvas>
                </div>
            </div>
            {{-- <div class="mt-8 mb-8 text-center">
                <a href="{{ url()->current() }}?reset=true"
                   onclick="return confirm('Apakah Anda yakin ingin mereset semua data keuangan? Tindakan ini tidak dapat diurungkan.');"
                   class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-150 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 mr-2 -mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Reset Semua Data
                </a>
            </div> --}}
            <div class="mt-8 mb-8 text-center">
                <form method="POST" action="{{ route('dashboard.reset') }}"
                    onsubmit="return confirm('Apakah Anda yakin ingin mereset semua data keuangan? Tindakan ini tidak dapat diurungkan.');">
                    @csrf
                    <button type="submit"
                        class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-150 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 mr-2 -mt-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Reset Semua Data
                    </button>

                </form>
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
            const ctxPengeluaranPemasukan = document.getElementById('lineChartPengeluaranPemasukan').getContext(
                '2d');
            new Chart(ctxPengeluaranPemasukan, {
                type: 'line',
                data: {
                    labels: dates,
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
