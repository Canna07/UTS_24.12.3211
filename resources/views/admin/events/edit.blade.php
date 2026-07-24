@extends('layouts.admin')

@section('content')

<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">
        Edit Event
    </h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.events.update', $event->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">

        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700">
                Kategori
            </label>

            <select name="category_id"
                    class="w-full border border-gray-300 p-2.5 rounded"
                    required>

                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ $event->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700">
                Judul Event
            </label>

            <input type="text"
                   name="title"
                   value="{{ old('title',$event->title) }}"
                   class="w-full border border-gray-300 p-2.5 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700">
                Deskripsi
            </label>

            <textarea name="description"
                      class="w-full border border-gray-300 p-2.5 rounded"
                      rows="5">{{ old('description',$event->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700">
                Tanggal
            </label>

            <input type="date"
                   name="date"
                   value="{{ old('date',$event->date) }}"
                   class="w-full border border-gray-300 p-2.5 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700">
                Lokasi
            </label>

            <input type="text"
                   name="location"
                   value="{{ old('location',$event->location) }}"
                   class="w-full border border-gray-300 p-2.5 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700">
                Harga
            </label>

            <input type="number"
                   name="price"
                   value="{{ old('price',$event->price) }}"
                   class="w-full border border-gray-300 p-2.5 rounded">
        </div>

        <div class="mb-6">
            <label class="block mb-2 font-medium text-gray-700">
                Stok
            </label>

            <input type="number"
                   name="stock"
                   value="{{ old('stock',$event->stock) }}"
                   class="w-full border border-gray-300 p-2.5 rounded">
        </div>

        {{-- Bagian Poster yang Baru Ditambahkan --}}
        <div class="mb-4">
            <label>Poster Event</label>

            <input
                type="file"
                name="poster"
                accept="image/*">

            @if($event->poster_path)
                <img
                    src="{{ asset('storage/'.$event->poster_path) }}"
                    width="120"
                    class="mt-2">
            @endif
        </div>

        <button type="submit"
                class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">
            Update Event
        </button>

    </form>

</div>

@endsection