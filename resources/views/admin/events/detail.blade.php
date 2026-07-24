@php
use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-12">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">

        <!-- Poster -->
        <div>
            <img
                src="{{ ($event->poster_path && Storage::disk('public')->exists($event->poster_path))
                    ? asset('storage/' . $event->poster_path)
                    : 'https://placehold.co/500x700' }}"
                alt="{{ $event->title }}"
                class="w-full rounded-3xl shadow-lg object-cover">
        </div>

        <!-- Detail Event -->
        <div>

            <span class="inline-block bg-indigo-100 text-indigo-700 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                {{ $event->category->name }}
            </span>

            <h1 class="text-4xl font-bold text-gray-800 mb-6">
                {{ $event->title }}
            </h1>

            <div class="space-y-4 text-gray-700">

                <p>
                    <strong>Tanggal :</strong><br>
                    {{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}
                </p>

                <p>
                    <strong>Lokasi :</strong><br>
                    {{ $event->location }}
                </p>

                <p>
                    <strong>Harga Tiket :</strong><br>
                    <span class="text-2xl font-bold text-indigo-600">
                        Rp {{ number_format($event->price,0,',','.') }}
                    </span>
                </p>

                <p>
                    <strong>Sisa Tiket :</strong><br>
                    {{ $event->stock }} Tiket lagi!
                </p>

                <div>
                    <strong>Deskripsi</strong>

                    <p class="mt-2 leading-7 text-gray-600">
                        {{ $event->description }}
                    </p>
                </div>

            </div>

            <div class="mt-8 flex gap-4">

                <a href="{{ url('checkout/'.$event->id) }}"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold">

                    Pesan Sekarang

                </a>

                <a href="{{ url('/') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-semibold">

                    Kembali

                </a>

            </div>

        </div>

    </div>

</div>

@endsection