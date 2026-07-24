@extends('layouts.app')

@section('content')

<main class="flex-1 p-10 overflow-y-auto bg-slate-50 min-h-screen">

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">

        <div>
            <h1 class="text-3xl font-black text-slate-800">
                Data Partner
            </h1>

            <p class="text-slate-500 mt-2">
                Kelola seluruh partner yang bekerja sama dengan event Anda.
            </p>
        </div>

        <a href="{{ route('admin.partners.create') }}"
            class="mt-4 md:mt-0 px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg hover:bg-indigo-700 transition">

            + Tambah Partner

        </a>

    </div>

    <!-- Success Message -->
    @if(session('success'))

        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-2xl">

            {{ session('success') }}

        </div>

    @endif

    <!-- Search -->
    <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6 mb-6">

        <form action="{{ route('admin.partners.index') }}" method="GET">

            <div class="flex gap-3">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="🔍 Cari partner..."
                    class="flex-1 px-5 py-3 border border-slate-300 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none">

                <button
                    type="submit"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition">

                    Search

                </button>

            </div>

        </form>

    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl shadow-lg border border-slate-100 overflow-hidden">

        <div class="px-8 py-6 border-b">

            <h2 class="text-xl font-bold text-slate-800">

                Daftar Partner

            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-100">

                    <tr class="text-left text-slate-600 uppercase text-xs">

                        <th class="px-6 py-4">ID</th>

                        <th class="px-6 py-4">Logo</th>

                        <th class="px-6 py-4">Nama Partner</th>

                        <th class="px-6 py-4 text-center">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($partners as $partner)

                    <tr class="border-t hover:bg-slate-50 transition">

                        <td class="px-6 py-4 font-semibold">

                            {{ $partner->id }}

                        </td>

                        <td class="px-6 py-4">

                            <img
                                src="{{ $partner->logo_url }}"
                                alt="{{ $partner->name }}"
                                class="w-20 h-20 object-contain rounded-xl border bg-white p-2"
                                onerror="this.src='https://placehold.co/80x80?text=Logo'">

                        </td>

                        <td class="px-6 py-4">

                            <h3 class="font-bold text-slate-800">

                                {{ $partner->name }}

                            </h3>

                        </td>

                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-3">

                                <a
                                    href="{{ route('admin.partners.edit', $partner->id) }}"
                                    class="px-4 py-2 bg-yellow-400 text-white rounded-xl hover:bg-yellow-500 transition">

                                    Edit

                                </a>

                                <form
                                    action="{{ route('admin.partners.destroy', $partner->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus partner ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="px-4 py-2 bg-red-500 text-white rounded-xl hover:bg-red-600 transition">

                                        Delete

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4" class="text-center py-10 text-slate-500">

                            Belum ada data partner.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</main>

@endsection