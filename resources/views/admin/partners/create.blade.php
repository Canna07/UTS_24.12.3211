@extends('layouts.app')

@section('content')

<main class="flex-1 p-10 overflow-y-auto bg-slate-50 min-h-screen">

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">

        <div>
            <h1 class="text-3xl font-black text-slate-800">
                Tambah Partner
            </h1>

            <p class="text-slate-500 mt-2">
                Tambahkan partner baru untuk mendukung event Anda.
            </p>
        </div>

        <a href="{{ route('partners.index') }}"
            class="px-5 py-3 bg-slate-200 text-slate-700 rounded-2xl font-semibold hover:bg-slate-300 transition">

            ← Kembali

        </a>

    </div>

    <!-- Card Form -->
    <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-8 max-w-3xl">

        <form action="{{ route('partners.store') }}" method="POST">

            @csrf

            <!-- Nama Partner -->
            <div class="mb-6">

                <label class="block mb-2 text-sm font-bold text-slate-700">

                    Nama Partner

                </label>

                <input
                    type="text"
                    name="name"
                    placeholder="Masukkan nama partner"
                    value="{{ old('name') }}"
                    class="w-full px-5 py-3 border border-slate-300 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">

                @error('name')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <!-- Logo -->
            <div class="mb-6">

                <label class="block mb-2 text-sm font-bold text-slate-700">

                    Logo URL

                </label>

                <input
                    type="text"
                    name="logo_url"
                    placeholder="https://example.com/logo.png"
                    value="{{ old('logo_url') }}"
                    class="w-full px-5 py-3 border border-slate-300 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">

                @error('logo_url')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <!-- Preview Logo -->
            <div class="mb-8">

                <label class="block mb-2 text-sm font-bold text-slate-700">

                    Preview Logo

                </label>

                <div class="border-2 border-dashed border-slate-300 rounded-2xl p-8 flex justify-center">

                    <img
                        id="preview"
                        src="https://placehold.co/180x80?text=Logo"
                        class="max-h-24 object-contain">

                </div>

            </div>

            <!-- Button -->
            <div class="flex gap-4">

                <button
                    type="submit"
                    class="px-8 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition">

                    💾 Simpan Partner

                </button>

                <a href="{{ route('partners.index') }}"
                    class="px-8 py-3 bg-slate-200 rounded-2xl font-bold hover:bg-slate-300 transition">

                    Batal

                </a>

            </div>

        </form>

    </div>

</main>

<script>

const input = document.querySelector('input[name="logo_url"]');
const preview = document.getElementById('preview');

input.addEventListener('input', function () {

    if(this.value.trim() !== ''){

        preview.src = this.value;

    }else{

        preview.src = 'https://placehold.co/180x80?text=Logo';

    }

});

</script>

@endsection