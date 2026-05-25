<!DOCTYPE html>
<html>
<head>
    <title>Tambah Event</title>
</head>
<body>

    <h1>Tambah Data Event</h1>

    <!-- tampilkan error validasi -->
    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('events.store') }}" method="POST">
        @csrf

        <label>Judul Event</label><br>
        <input type="text" name="title"><br><br>

        <label>Deskripsi</label><br>
        <textarea name="description"></textarea><br><br>

        <label>Tanggal</label><br>
        <input type="datetime-local" name="date"><br><br>

        <label>Lokasi</label><br>
        <input type="text" name="location"><br><br>

        <label>Harga</label><br>
        <input type="number" name="price"><br><br>

        <label>Stok</label><br>
        <input type="number" name="stock"><br><br>

        <button type="submit">Simpan</button>
    </form>

    <br>
    <a href="{{ route('events.index') }}">Kembali</a>

</body>
</html>