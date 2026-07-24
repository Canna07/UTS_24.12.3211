<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Event</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100">

<div class="max-w-4xl mx-auto mt-10">

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <div class="bg-indigo-600 px-8 py-6">
            <h1 class="text-3xl font-bold text-white">
                Tambah Event Baru
            </h1>
            <p class="text-indigo-100 mt-1">
                Lengkapi data event di bawah ini.
            </p>
        </div>

        <div class="p-8">

            @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-300 text-red-700 rounded-lg p-4">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.events.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="grid grid-cols-2 gap-6">

                    <div>
                        <label class="block mb-2 font-semibold">
                            Kategori
                        </label>

                        <select name="category_id"
                            class="w-full border rounded-lg p-3">

                            <option value="">Pilih Kategori</option>

                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">
                            Judul Event
                        </label>

                        <input
                            type="text"
                            name="title"
                            class="w-full border rounded-lg p-3"
                            placeholder="Masukkan Judul Event">
                    </div>

                    <div class="col-span-2">
                        <label class="block mb-2 font-semibold">
                            Deskripsi
                        </label>

                        <textarea
                            name="description"
                            rows="4"
                            class="w-full border rounded-lg p-3"
                            placeholder="Deskripsi Event"></textarea>
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">
                            Tanggal Event
                        </label>

                        <input
                            type="datetime-local"
                            name="date"
                            class="w-full border rounded-lg p-3">
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">
                            Lokasi
                        </label>

                        <input
                            type="text"
                            name="location"
                            class="w-full border rounded-lg p-3">
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">
                            Harga Tiket
                        </label>

                        <input
                            type="number"
                            name="price"
                            class="w-full border rounded-lg p-3">
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">
                            Stok Tiket
                        </label>

                        <input
                            type="number"
                            name="stock"
                            class="w-full border rounded-lg p-3">
                    </div>

                    <div class="col-span-2">
                        <label class="block mb-2 font-semibold">
                            Poster Event
                        </label>

                        <input
                            type="file"
                            name="poster"
                            accept="image/*"
                            class="w-full border rounded-lg p-3">
                    </div>

                </div>

                <div class="mt-8 flex justify-end gap-3">

                    <a href="{{ route('admin.events.index') }}"
                        class="px-6 py-3 bg-gray-200 rounded-lg hover:bg-gray-300">

                        Kembali

                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">

                        Simpan Event

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>