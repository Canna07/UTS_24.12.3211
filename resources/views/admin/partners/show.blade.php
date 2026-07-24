@extends('layouts.app')

@section('content')

<main class="flex-1 p-10 overflow-y-auto bg-slate-50 min-h-screen">

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">

        <div>
            <h1 class="text-3xl font-black text-slate-800">
                Detail Partner
            </h1>

            <p class="text-slate-500 mt-2">
                Informasi lengkap mengenai partner.
            </p>
        </div>

        <a href="{{ route('partners.index') }}"
            class="mt-4 md:mt-0 px-6 py-3 bg-slate-200 text-slate-700 rounded-2xl font-bold hover:bg-slate-300 transition">

            ← Kembali

        </a>

    </div>

    <!-- Card -->
    <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-10 max-w-4xl">

        <div class="grid md:grid-cols-2 gap-10 items-center">

            <!-- Logo -->
            <div class="flex justify-center">

                <div class="bg-slate-50 border rounded-3xl p-8">

                    <img
                        src="{{ $partner->logo_url }}"
                        alt="{{ $partner->name }}"
                        class="max-h-48 object-contain"
                        onerror="this.src='https://placehold.co/250x150?text=No+Logo'">

                </div>

            </div>

            <!-- Detail -->
            <div>

                <h2 class="text-3xl font-black text-slate-800 mb-6">

                    {{ $partner->name }}

                </h2>

                <div class="space-y-5">

                    <div>

                        <p class="text-sm text-slate-500">
                            ID Partner
                        </p>

                        <p class="font-bold text-lg">
                            #{{ $partner->id }}
                        </p>

                    </div>

                    <div>

                        <p class="text-sm text-slate-500">
                            Nama Partner
                        </p>

                        <p class="font-semibold text-lg">
                            {{ $partner->name }}
                        </p>

                    </div>

                    <div>

                        <p class="text-sm text-slate-500">
                            Logo URL
                        </p>

                        <a href="{{ $partner->logo_url }}"
                           target="_blank"
                           class="text-indigo-600 hover:underline break-all">

                            {{ $partner->logo_url }}

                        </a>

                    </div>

                    <div>

                        <p class="text-sm text-slate-500">
                            Dibuat
                        </p>

                        <p>
                            {{ $partner->created_at->format('d M Y H:i') }}
                        </p>

                    </div>

                    <div>

                        <p class="text-sm text-slate-500">
                            Terakhir Diubah
                        </p>

                        <p>
                            {{ $partner->updated_at->format('d M Y H:i') }}
                        </p>

                    </div>

                </div>

                <!-- Button -->
                <div class="flex gap-4 mt-10">

                    <a href="{{ route('partners.edit', $partner->id) }}"
                        class="px-6 py-3 bg-yellow-400 text-white rounded-2xl font-bold hover:bg-yellow-500 transition">

                        ✏️ Edit

                    </a>

                    <form
                        action="{{ route('partners.destroy', $partner->id) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus partner ini?')">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="px-6 py-3 bg-red-500 text-white rounded-2xl font-bold hover:bg-red-600 transition">

                            🗑️ Hapus

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</main>

@endsection