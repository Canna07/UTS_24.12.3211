@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center gap-12">
        <div class="flex-1 space-y-8">
            <span
                class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">#1
                Event Platform</span>
            <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
                Temukan & Pesan <span class="text-indigo-600">Tiket Event</span> Impianmu.
            </h1>
            <p class="text-lg text-slate-500 max-w-lg leading-relaxed">
                Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman & cepat dengan
                Midtrans.
            </p>
            <div class="flex gap-4">
                <a href="#events"
                    class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform">
                    Mulai Jelajah
                </a>
                <a href="#"
                    class="px-8 py-4 border-2 border-slate-200 rounded-2xl font-bold text-lg hover:border-indigo-600 hover:text-indigo-600 transition">
                    Cara Pesan
                </a>
            </div>
        </div>
        <div class="flex-1 relative">
            <div
                class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
            </div>
            <div
                class="absolute -bottom-10 -right-10 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
            </div>
            <img src="assets/concert.png" alt="Concert"
                class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover aspect-[4/5] object-center">

            <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl z-20 border border-white">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
                        <p class="font-bold">Pembayaran Aman via Midtrans</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

@foreach($events as $event)

<div class="bg-white rounded-3xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">

    <div class="h-60 bg-gray-100 overflow-hidden">
        @if($event->poster_path)
            <img src="{{ asset('storage/'.$event->poster_path) }}"
                alt="{{ $event->title }}"
                class="w-full h-full object-cover hover:scale-105 transition duration-300">
        @else
            <img src="https://placehold.co/400x600"
                class="w-full h-full object-cover">
        @endif
    </div>

    <div class="p-6">

        <span class="inline-block px-3 py-1 text-xs font-bold bg-indigo-100 text-indigo-600 rounded-full mb-3">
            {{ $event->category->name ?? 'Event' }}
        </span>

        <h3 class="text-xl font-bold text-gray-800 line-clamp-2">
            {{ $event->title }}
        </h3>

        <div class="mt-3 space-y-2 text-gray-500 text-sm">

            <p>
                📅 {{ \Carbon\Carbon::parse($event->date)->format('d M Y H:i') }}
            </p>

            <p>
                📍 {{ $event->location }}
            </p>

        </div>

        <div class="flex justify-between items-center mt-6">

            <div>
                <p class="text-xs text-gray-400">Mulai dari</p>
                <p class="text-2xl font-black text-indigo-600">
                    Rp {{ number_format($event->price,0,',','.') }}
                </p>
            </div>

            <a href="{{ route('events.show',$event->id) }}"
                class="px-5 py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition">
                Detail
            </a>
            <a href="{{ route('checkout.create', $event->id) }}"
    class="px-5 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition">
    Checkout
</a>

        </div>

    </div>

</div>

@endforeach

</div>

    <section class="container mt-5">

    <div class="text-center mb-5">
        <h2>Partner AmikomEventHub</h2>
        <p>
            Platform yang mendukung kegiatan dan event kampus
        </p>
    </div>

    <div class="row">

        @foreach($partners as $partner)

            <div class="col-md-4 mb-4">

                <div class="card shadow-sm border-0 h-100">

                    <div class="card-body text-center">

                        {{-- Logo Partner --}}
                        @if($partner->logo)
                            <img 
                                src="{{ asset('storage/' . $partner->logo) }}" 
                                alt="Logo Partner"
                                class="img-fluid mb-3"
                                style="height:100px; object-fit:contain;"
                            >
                        @endif

                        {{-- Nama Partner --}}
                        <h5 class="fw-bold">
                            {{ $partner->name }}
                        </h5>

                        {{-- Deskripsi --}}
                        <p class="text-muted">
                            {{ $partner->description }}
                        </p>

                        {{-- Kategori --}}
                        <span class="badge bg-primary">
                            {{ $partner->category }}
                        </span>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</section>

@endsection