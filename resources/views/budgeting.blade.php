<x-app-layout>
    <main class="py-10">
        <div class="px-4 sm:px-6 lg:px-8">
            <div>
                <h1 class="text-xl font-semibold">Budgeting</h1>
                <p class="mt-2 text-gray-600">Kelola keuanganmu yuk!</p>
            </div>

            <!-- Form untuk Menambah Saldo -->
            <div class="mt-6 bg-white p-6 rounded-md shadow">
                <h2 class="text-lg font-semibold mb-4">Tambah Saldo</h2>
                <form action="{{ route('tambah.saldo') }}" method="POST">
                    @csrf
                    <div class="flex justify-between items-center gap-4">
                        <label for="saldo" class="text-xs text-gray-600 whitespace-nowrap">Rp</label>
                        <input type="number" name="saldo" id="saldo"
                            class="border rounded-md px-2 py-1 text-sm w-full" placeholder="Masukkan saldo" required>
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-1 rounded-md hover:bg-blue-600 text-sm">
                            Tambah
                        </button>
                    </div>
                </form>
            </div>

            {{-- <!-- Menampilkan Riwayat Budgeting (Jika ada) -->
            <div class="mt-6 bg-white p-6 rounded-md shadow">
                <h2 class="text-lg font-semibold mb-4">Riwayat Budgeting</h2>
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Tanggal</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Jumlah Saldo</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($saldoTransactions as $transaction)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ number_format($transaction->jumlah, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $transaction->description ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> --}}
        </div>
    </main>
</x-app-layout>
