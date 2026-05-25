@extends('layouts.app')

@section('content')

<h2>Data Partner</h2>

<form action="" method="GET">
    <input type="text" name="search" placeholder="Search partner">
    <button type="submit">Search</button>
</form>

<a href="{{ route('partners.create') }}">Tambah Partner</a>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Logo</th>
        <th>Aksi</th>
    </tr>

    @foreach($partners as $partner)
    <tr>
        <td>{{ $partner->id }}</td>
        <td>{{ $partner->name }}</td>
        <td>
            <img src="{{ $partner->logo_url }}" width="100">
        </td>
        <td>
            <a href="{{ route('partners.edit', $partner->id) }}">Edit</a>

            <form action="{{ route('partners.destroy', $partner->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

@endsection