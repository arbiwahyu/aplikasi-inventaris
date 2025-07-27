<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-400 rounded" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-400 rounded" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- TAMBAHKAN KODE BARU DI SINI --}}
                    @if (session()->has('import_errors'))
                        <div class="mb-4 p-4 bg-red-100 text-red-800 border border-red-400 rounded">
                            <p class="font-bold mb-2">Import Gagal. Ditemukan {{ count(session('import_errors')) }}
                                kesalahan pada file Anda:</p>
                            <ul class="list-disc pl-5">
                                @foreach (session('import_errors') as $failure)
                                    <li>
                                        Baris ke-{{ $failure->row() }}: {{ $failure->errors()[0] }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @can('manage items')
                        <div class="mb-4">
                            <a href="{{ route('items.create') }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                + Tambah Barang
                            </a>
                            <a href="{{ route('items.export') }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Export ke Excel
                            </a>

                            <div class="mt-4 border-t pt-4">
                                <div class="flex justify-between items-center mb-2">
                                    <h3 class="text-lg font-medium">Import Data Barang</h3>
                                    <a href="{{ route('items.import-format') }}"
                                        class="text-sm text-blue-600 hover:underline font-medium">
                                        Unduh Format Import
                                    </a>
                                </div>
                                <form action="{{ route('items.import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="flex items-center">
                                        <input type="file" name="file" required
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        <button type="submit"
                                            class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded ml-4">
                                            Import
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endcan

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama Barang</th>
                                    <th scope="col" class="px-6 py-3">Kategori</th>
                                    <th scope="col" class="px-6 py-3">Lokasi</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Kondisi</th>
                                    <th scope="col" class="px-6 py-3"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $item)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            @if ($item->image)
                                                <img src="{{ asset('storage/' . $item->image) }}"
                                                    alt="{{ $item->name }}"
                                                    class="w-16 h-16 object-cover rounded-md inline-block mr-2">
                                            @endif
                                            <div class="inline-block align-middle">
                                                {{ $item->name }} <br>
                                                <small class="text-gray-500">{{ $item->item_code }}</small>
                                            </div>
                                        </th>
                                        <td class="px-6 py-4">{{ $item->category->name }}</td>
                                        <td class="px-6 py-4">{{ $item->location->name }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
            {{ $item->status == 'Tersedia' ? 'bg-green-100 text-green-800' : '' }}
            {{ $item->status == 'Dipinjam' ? 'bg-yellow-100 text-yellow-800' : '' }}
            {{ $item->status == 'Perbaikan' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">{{ $item->condition }}</td>
                                        <td class="px-6 py-4 text-right flex items-center justify-end space-x-4">
                                            <div class="flex items-center justify-end space-x-4">
                                                {{-- Tombol Pinjam & Kembalikan dilindungi dengan @can --}}
                                                @can('borrow items')
                                                    @if ($item->status == 'Tersedia')
                                                        <form action="{{ route('items.borrow', $item->id) }}"
                                                            method="POST" onsubmit="return confirm('Pinjam barang ini?');">
                                                            @csrf
                                                            <button type="submit"
                                                                class="font-medium text-green-600 hover:underline">Pinjam</button>
                                                        </form>
                                                    @elseif($item->status == 'Dipinjam')
                                                        {{-- Logika untuk memeriksa apakah user ini yang meminjam --}}
                                                        @php
                                                            $borrowing = $item
                                                                ->borrowings()
                                                                ->where('user_id', auth()->id())
                                                                ->whereNull('return_date')
                                                                ->first();
                                                        @endphp
                                                        @if ($borrowing)
                                                            <form action="{{ route('items.return', $item->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Kembalikan barang ini?');">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="font-medium text-orange-600 hover:underline">Kembalikan</button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                @endcan

                                                {{-- Tombol Cetak, Edit, dan Hapus dilindungi dengan @can --}}
                                                @can('manage items')
                                                    <a href="{{ route('items.label', $item->id) }}" target="_blank"
                                                        class="font-medium text-gray-600 hover:underline">Label</a>

                                                    <a href="{{ route('items.edit', $item->id) }}"
                                                        class="font-medium text-blue-600 hover:underline">Edit</a>
                                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST"
                                                        onsubmit="return confirm('Apakah Anda yakin?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="font-medium text-red-600 hover:underline">Hapus</button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada data barang.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $items->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
