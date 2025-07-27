<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-500">Total Barang</h3>
                        <p class="mt-1 text-4xl font-semibold">{{ $totalItems }}</p>
                    </div>
                </div>

                <div class="bg-green-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-green-900">
                        <h3 class="text-lg font-medium text-green-700">Barang Tersedia</h3>
                        <p class="mt-1 text-4xl font-semibold">{{ $availableItems }}</p>
                    </div>
                </div>

                <div class="bg-yellow-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-yellow-900">
                        <h3 class="text-lg font-medium text-yellow-700">Barang Dipinjam</h3>
                        <p class="mt-1 text-4xl font-semibold">{{ $borrowedItems }}</p>
                    </div>
                </div>

                <div class="bg-gray-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-500">Total Pengguna</h3>
                        <p class="mt-1 text-4xl font-semibold">{{ $totalUsers }}</p>
                    </div>
                </div>

            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Selamat datang di Aplikasi Inventaris!
                </div>
            </div>
        </div>
    </div>
</x-app-layout>