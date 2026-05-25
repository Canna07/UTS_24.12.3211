{{-- resources/views/admin/categories/index.blade.php --}}

@extends('layouts.admin')

@section('content')

<div class="p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">

        <h1 class="text-2xl font-bold text-gray-800">
            Manajemen Kategori
        </h1>

        <a href="#form-tambah"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">

            + Tambah Kategori

        </a>

    </div>

    <!-- ALERT SUCCESS -->
    @if(session('success'))

        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">

            {{ session('success') }}

        </div>

    @endif

    <!-- ALERT ERROR -->
    @if(session('error'))

        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">

            {{ session('error') }}

        </div>

    @endif

    <!-- SEARCH -->
    <form
        action="{{ route('categories.index') }}"
        method="GET"
        class="mb-6"
    >

        <div class="flex gap-2">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari kategori..."
                class="border border-gray-300 rounded-lg px-4 py-2 w-full"
            >

            <button
                type="submit"
                class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900"
            >

                Search

            </button>

        </div>

    </form>

    <!-- FORM TAMBAH -->
    <div
        id="form-tambah"
        class="bg-white shadow rounded-lg p-6 mb-6"
    >

        <h2 class="text-lg font-semibold mb-4">

            Tambah Kategori

        </h2>

        <form
            action="{{ route('categories.store') }}"
            method="POST"
        >

            @csrf

            <!-- NAME -->
            <div class="mb-4">

                <label class="block mb-2 font-medium text-gray-700">

                    Nama Kategori

                </label>

                <input
                    type="text"
                    name="name"
                    placeholder="Masukkan nama kategori"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                    required
                >

            </div>

            <!-- SLUG -->
            <div class="mb-4">

                <label class="block mb-2 font-medium text-gray-700">

                    Slug

                </label>

                <input
                    type="text"
                    name="slug"
                    placeholder="contoh: seminar-teknologi"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                    required
                >

            </div>

            <!-- BUTTON -->
            <button
                type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700"
            >

                Simpan

            </button>

        </form>

    </div>

    <!-- TABLE -->
    <div class="bg-white shadow rounded-lg overflow-hidden">

        <table class="min-w-full text-sm text-left">

            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">

                <tr>

                    <th class="px-6 py-3">No</th>

                    <th class="px-6 py-3">Nama Kategori</th>

                    <th class="px-6 py-3">Slug</th>

                    <th class="px-6 py-3">Created At</th>

                    <th class="px-6 py-3">Updated At</th>

                    <th class="px-6 py-3 text-center">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody class="text-gray-700">

                @forelse($categories as $index => $category)

                <tr class="border-b hover:bg-gray-50">

                    <!-- NO -->
                    <td class="px-6 py-4">

                        {{ $index + 1 }}

                    </td>

                    <!-- NAME -->
                    <td class="px-6 py-4">

                        {{ $category->name }}

                    </td>

                    <!-- SLUG -->
                    <td class="px-6 py-4">

                        {{ $category->slug }}

                    </td>

                    <!-- CREATED -->
                    <td class="px-6 py-4">

                        {{ $category->created_at }}

                    </td>

                    <!-- UPDATED -->
                    <td class="px-6 py-4">

                        {{ $category->updated_at }}

                    </td>

                    <!-- AKSI -->
                    <td class="px-6 py-4">

                        <div class="flex flex-col gap-3">

                            <!-- FORM UPDATE -->
                            <form
                                action="{{ route('categories.update', $category->id) }}"
                                method="POST"
                                class="flex gap-2"
                            >

                                @csrf
                                @method('PUT')

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ $category->name }}"
                                    class="border border-gray-300 rounded px-2 py-1 w-full"
                                    required
                                >

                                <input
                                    type="text"
                                    name="slug"
                                    value="{{ $category->slug }}"
                                    class="border border-gray-300 rounded px-2 py-1 w-full"
                                    required
                                >

                                <button
                                    type="submit"
                                    class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500"
                                >

                                    Update

                                </button>

                            </form>

                            <!-- FORM DELETE -->
                            <form
                                action="{{ route('categories.destroy', $category->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 w-full"
                                >

                                    Hapus

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td
                        colspan="6"
                        class="text-center py-6 text-gray-500"
                    >

                        Data kategori belum tersedia

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection