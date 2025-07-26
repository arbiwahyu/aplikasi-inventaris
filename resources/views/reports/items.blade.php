<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Form Filter --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Filter Laporan</h3>
                    <form action="{{ route('reports.items') }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            {{-- Filter Lokasi --}}
                            <div>
                                <label for="location_id" class="block text-sm font-medium text-gray-700">Lokasi</label>
                                <select name="location_id" id="location_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Semua Lokasi</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Filter Tanggal Mulai --}}
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Dari Tanggal Pembelian</label>
                                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            {{-- Filter Tanggal Selesai --}}
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">Sampai Tanggal Pembelian</label>
                                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Tampilkan Laporan
                            </button>
                            <a href="{{ route('reports.items') }}" class="text-sm text-gray-600 hover:text-gray-900 ml-4">
                                Reset Filter
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabel Hasil Laporan --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama Barang</th>
                                    <th scope="col" class="px-6 py-3">Kategori</th>
                                    <th scope="col" class="px-6 py-3">Lokasi</th>
                                    <th scope="col" class="px-6 py-3">Tgl. Beli</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $item)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $item->name }}
                                    </th>
                                    <td class="px-6 py-4">{{ $item->category->name }}</td>
                                    <td class="px-6 py-4">{{ $item->location->name }}</td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item->purchase_date)->format('d-m-Y') }}</td>
                                    <td class="px-6 py-4">{{ $item->status }}</td>
                                    <td class="px-6 py-4">{{ $item->condition }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada data yang cocok dengan filter.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>