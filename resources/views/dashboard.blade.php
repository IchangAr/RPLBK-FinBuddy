<x-app-layout>
    <main class="py-10">
        <div class="px-4 sm:px-6 lg:px-8">
            <div>
                <h1 class="text-xl font-semibold">Selamat datang di FinBuddy</h1>
                <p class="mt-2 text-gray-600">Siap mengelola keuangan anda.</p>
            </div>
            <div class="mt-6 bg-white p-6 rounded-md shadow">
                <div class="flex justify-between items-center">
                    <p class="text-xs text-gray-600">Saldo anda saat ini : - </p>
                    <a  href="budgeting" class=" text-xs bg-[#111827] text-white px-2 py-1 rounded-md hover:bg-[#212f4d]">
                        Tambah Saldo
                    </a>
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
