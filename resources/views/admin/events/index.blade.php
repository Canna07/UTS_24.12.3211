@extends('layouts.admin')

@section('content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-2xl font-bold text-gray-800">
            Manajemen Event
        </h1>

        <a href="{{ route('admin.events.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">

            + Tambah Event

        </a>

    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">

        <table class="min-w-full text-sm">

            <thead class="bg-gray-100">

                <tr>

                    <th class="px-4 py-3">No</th>

                    <th class="px-4 py-3">Poster</th>

                    <th class="px-4 py-3">Judul</th>

                    <th class="px-4 py-3">Kategori</th>

                    <th class="px-4 py-3">Tanggal</th>

                    <th class="px-4 py-3">Lokasi</th>

                    <th class="px-4 py-3">Harga</th>

                    <th class="px-4 py-3">Stok</th>

                    <th class="px-4 py-3 text-center">Aksi</th>

                </tr>

            </thead>

            <tbody>

            @forelse($events as $index => $event)

                <tr class="border-b hover:bg-gray-50">

                    <td class="px-4 py-4">
                        {{ $index + 1 }}
                    </td>

                    <td class="px-4 py-4">

                        <img 
                        src="{{ ($event->poster_path && Storage::disk('public')->exists($event->poster_path))
                        ? asset('storage/'.$event->poster_path)
                        : 'https://placehold.co/120x150' }}"
                        class="w-16 h-20 object-cover rounded">

                    </td>

                    <td class="px-4 py-4">
                        {{ $event->title }}
                    </td>

                    <td class="px-4 py-4">
                        {{ $event->category->name ?? '-' }}
                    </td>

                    <td class="px-4 py-4">
                        {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                    </td>

                    <td class="px-4 py-4">
                        {{ $event->location }}
                    </td>

                    <td class="px-4 py-4">
                        Rp {{ number_format($event->price,0,',','.') }}
                    </td>

                    <td class="px-4 py-4">
                        {{ $event->stock }}
                    </td>

                    <td class="px-4 py-4">

                        <div class="flex gap-2">

                            <a href="{{ route('admin.events.edit',$event->id) }}"
                               class="bg-yellow-400 text-white px-3 py-2 rounded hover:bg-yellow-500">

                                Edit

                            </a>

                            <form
                                action="{{ route('admin.events.destroy',$event->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus event ini?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600">

                                    Hapus

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="9" class="text-center py-6 text-gray-500">

                        Belum ada data event.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection