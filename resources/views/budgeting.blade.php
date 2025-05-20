<x-app-layout>
    <main class="py-10">
        <div class="px-4 sm:px-6 lg:px-8">
            <div>
                <h1 class="ml-8 text-5xl font-bold">Budgeting</h1>
                <p class="text-sm text-gray-600 ml-2">Kelola Keuanganmu yuuuk!</p>
            </div>

            <!-- Form Gabungan untuk Tambah Saldo dan Komentar -->
            <div class="mt-6 bg-white p-6 rounded-md shadow">
                <h2 class="text-lg font-semibold mb-4">Tambah Saldo</h2>
                <form action="{{ route('tambah.saldo') }}" method="POST">
                    @csrf

                    <!-- Input Saldo -->
                    <div class="flex items-center gap-3 mb-4">
                        <label for="saldo" class="text-sm text-gray-600 whitespace-nowrap">Rp</label>
                        <input type="number" name="saldo" id="saldo"
                            class="border rounded-md px-2 py-1 text-sm w-full mr-4" placeholder="Masukkan saldo" required>
                    </div>

                    <!-- Komentar -->
                    <div
                        class="relative rounded-xl bg-white outline outline-1 outline-gray-300 focus-within:outline-indigo-600 shadow-sm transition-all mb-4 mr-4 ml-7">
                        <label for="deskripsi" class="sr-only">Add your comment</label>
                        <textarea rows="2" name="deskripsi" id="deskripsi"
                            class="block w-full resize-none bg-transparent px-3 py-2 text-xs text-gray-800 placeholder-gray-400 border-none outline-none ring-0 focus:outline-none focus:ring-0 focus:border-none"
                            placeholder="Tambahkan Catatan..."></textarea>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="text-right">
                        <button type="submit"
                            class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 transition-all focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-indigo-600 mr-4">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</x-app-layout>
