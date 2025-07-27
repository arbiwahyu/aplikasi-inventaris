<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Log Aktivitas Sistem') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Deskripsi</th>
                                    <th scope="col" class="px-6 py-3">Subjek</th>
                                    <th scope="col" class="px-6 py-3">Pelaku</th>
                                    <th scope="col" class="px-6 py-3">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($activities as $activity)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $activity->description }}</td>
                                        <td class="px-6 py-4">
                                            {{-- Menampilkan nama class tanpa namespace --}}
                                            {{ class_basename($activity->subject_type) }} ID:
                                            {{ $activity->subject_id }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{-- Tampilkan nama user jika ada, jika tidak tampilkan 'Sistem' --}}
                                            {{ optional($activity->causer)->name ?? 'Sistem' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $activity->created_at->format('d M Y, H:i') }}
                                            <br>
                                            <small
                                                class="text-gray-500">{{ $activity->created_at->diffForHumans() }}</small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada aktivitas yang tercatat.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $activities->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
