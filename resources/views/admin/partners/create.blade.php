@extends('layouts.app')

@section('content')

<h2>Tambah Partner</h2>

<form action="{{ route('partners.store') }}" method="POST">
    @csrf

    <input type="text" name="name" placeholder="Nama Partner">

    <input type="text" name="logo_url" placeholder="Logo URL">

    <button type="submit">Simpan</button>
</form>

@endsection