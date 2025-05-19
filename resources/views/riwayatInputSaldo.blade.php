<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold text-gray-900">Riwayat Transaksi Pengeluaran</h1>
                <p class="mt-2 text-sm text-gray-700">
                    Berikut adalah daftar riwayat transaksi pengeluaran Anda.
                </p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <button type="button"
                    class="block rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                    Export
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
