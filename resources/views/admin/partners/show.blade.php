@extends('layouts.admin')

@section('content')

<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">{{ $partner->name }}</h1>

    <img src="{{ $partner->logo_url }}" width="200">
</div>

@endsection