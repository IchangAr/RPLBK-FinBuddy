<x-app-layout>
    <main class="py-10">
        <div class="px-4 sm:px-6 lg:px-8">
            <div>
                <h1 class="text-xl font-semibold">Budgeting</h1>
                <p class="mt-2 text-gray-600">Kelola keuanganmu yuk!</p>
            </div>
            <div class="mt-6 bg-white p-6 rounded-md shadow">
                <form action="{{ route('tambah.saldo') }}" method="POST">
                    @csrf
                    <div class="flex justify-between items-center gap-4">
                        <label for="saldo" class="text-xs text-gray-600 whitespace-nowrap">Rp</label>
                        <input type="number" name="saldo" id="saldo"
                            class="border rounded-md px-2 py-1 text-sm w-full" placeholder="Masukkan saldo">
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-1 rounded-md hover:bg-blue-600 text-sm">
                            Tambah
                        </button>
                    </div>
                </form>
            </div>


    </main>
</x-app-layout>
