<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold text-gray-900">Riwayat Input Saldo</h1>
                <p class="mt-2 text-sm text-gray-700">
                    Berikut adalah daftar riwayat input saldo Anda.
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
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th class="py-3.5 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                                <th class="px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Deskripsi</th>
                                <th class="px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Jumlah</th>
                                <th class="px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Kategori Budget</th>

                                <th class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach ($incomes as $income)
                                <tr>
                                    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">{{ $income->created_at->format('d M Y') }}</td>
                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{ $income->description ?? 'No description' }}</td>
                                    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">Rp.{{ number_format($income->amount, 2) }}</td>
                                    <td class="whitespace-nowrap px-2 py-2 text-sm text-green-600">{{ $income->budget_category ?? 'No category' }}</td>
                                    <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                        <!-- Add action buttons if needed -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
