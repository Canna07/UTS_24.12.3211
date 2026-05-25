@extends('layouts.app')

@section('content')

<h2>Edit Partner</h2>

<form action="{{ route('partners.update', $partner->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $partner->name }}">

    <input type="text" name="logo_url" value="{{ $partner->logo_url }}">

    <button type="submit">Update</button>
</form>

@endsection