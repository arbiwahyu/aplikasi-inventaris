<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cek Ketersediaan Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Form Filter --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Pilih Tanggal</h3>
                    <form action="{{ route('reports.availability') }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="check_date" class="block text-sm font-medium text-gray-700">Tanggal
                                    Pengecekan</label>
                                <input type="date" name="check_date" id="check_date"
                                    value="{{ request('check_date', now()->format('Y-m-d')) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Cek Ketersediaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Hanya tampilkan tabel jika ada request --}}
            @if (request()->filled('check_date'))
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">
                            Hasil: Barang yang Tersedia pada Tanggal
                            {{ \Carbon\Carbon::parse(request('check_date'))->format('d F Y') }}
                        </h3>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Nama Barang</th>
                                        <th scope="col" class="px-6 py-3">Kategori</th>
                                        <th scope="col" class="px-6 py-3">Lokasi</th>
                                        <th scope="col" class="px-6 py-3">Kondisi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($items as $item)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $item->name }}
                                            </th>
                                            <td class="px-6 py-4">{{ $item->category->name }}</td>
                                            <td class="px-6 py-4">{{ $item->location->name }}</td>
                                            <td class="px-6 py-4">{{ $item->condition }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                                Tidak ada barang yang tersedia pada tanggal tersebut.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
