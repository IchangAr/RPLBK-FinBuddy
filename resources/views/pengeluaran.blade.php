<x-app-layout>
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 mb-10">
        <div class="mt-6 bg-white p-8 rounded-lg shadow-lg">
            <div class="mb-4">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center text-sm font-semibold text-[#3B577D] hover:text-[#4d71a3]">
                    <span class="text-2xl mr-2">←</span>Kembali ke Home
                </a>
            </div>

            <div class="sm:flex-auto mb-7">
                <p class="ml-8 text-sm text-gray-600 leading-tight mb-1">Input</p>
                <h1 class="text-3xl font-bold leading-tight">Pemasukan Keuangan kamu</h1>
            </div>

            <form action="{{ route('tambah.saldo') }}" method="POST" id="form-budgeting">
                @csrf

                @if (session('success'))
                    <div x-data="{ open: true }" x-show="open" x-transition class="mb-4">
                        @include('components.modal-success')
                    </div>
                @endif

                <!-- Pilih Kategori -->
                <div class="mb-6">
                    <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-2">Silahkan Pilih Kategori</label>
                    <select id="kategori" name="kategori"
                        class="w-full rounded-md border border-gray-300 bg-white py-2 pl-4 pr-10 text-sm text-gray-800 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                        <option selected>Pilih Kategori</option>
                        <option>Kebutuhan</option>
                        <option>Kebutuhan</option>
                        <option>Keinginan</option>
                        <option>Tabungan</option>
                        <option>Utang & Credit</option>
                    </select>
                </div>

                <!-- Saldo -->
                <div class="mb-6">
                    <label for="saldo" class="block text-sm font-semibold text-gray-700 mb-2">Saldo Saat Ini</label>
                    <span class="text-sm text-gray-600">Rp. - </span>
                </div>

                <!-- Tanggal -->
                <div class="mb-6">
                    <label for="datepicker" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Tanggal</label>
                    <div class="relative">
                        <input id="datepicker" name="tanggal" readonly
                            class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 pr-10 text-sm text-gray-800 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 cursor-pointer"
                            placeholder="Pilih tanggal">
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10m-12 8h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Catatan -->
                <div class="mb-6">
                    <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">Catatan</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3"
                        class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-800 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300"
                        placeholder="Tambahkan catatan pengeluaran..."></textarea>
                </div>

                <!-- Tombol Submit -->
                <div class="text-center">
                    <button type="submit"
                        class="inline-flex items-center rounded-md bg-[#3B577D] px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#4d71a3] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                        Simpan Pengeluaran
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
