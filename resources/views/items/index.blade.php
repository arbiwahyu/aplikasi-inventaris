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

                    <div class="mb-4">
                        <a href="{{ route('items.create') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Tambah Barang
                        </a>
                    </div>

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
                                                @if ($item->status == 'Tersedia')
                                                    <form action="{{ route('items.borrow', $item->id) }}"
                                                        method="POST" onsubmit="return confirm('Pinjam barang ini?');">
                                                        @csrf
                                                        <button type="submit"
                                                            class="font-medium text-green-600 hover:underline">Pinjam</button>
                                                    </form>
                                                @elseif($item->status == 'Dipinjam')
                                                    <form action="{{ route('items.return', $item->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Kembalikan barang ini?');">
                                                        @csrf
                                                        <button type="submit"
                                                            class="font-medium text-orange-600 hover:underline">Kembalikan</button>
                                                    </form>
                                                @endif

                                                <a href="{{ route('items.label', $item->id) }}" target="_blank"
                                                    class="font-medium text-gray-600 hover:underline">Cetak Label</a>
                                                <a href="{{ route('items.edit', $item->id) }}"
                                                    class="font-medium text-blue-600 hover:underline">Edit</a>


                                                <a href="{{ route('items.edit', $item->id) }}"
                                                    class="font-medium text-blue-600 hover:underline">Edit</a>
                                                <form action="{{ route('items.destroy', $item->id) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="font-medium text-red-600 hover:underline">
                                                        Hapus
                                                    </button>
                                                </form>
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
