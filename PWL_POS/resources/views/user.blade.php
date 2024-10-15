<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data User</title>
</head>
<body>
    <h1>Data User</h1>
    <a href="{{ route('tambah') }}">+ Tambah User</a>
    <table border="1" cellpadding="2" cellspadding="0">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Nama</th>
            <th>ID level Pengguna</th>
            <th>Kode level Pengguna</th>
            <th>Nama level Pengguna</th>
            <th>Action</th>
        </tr>
        @foreach ($data as $d)
            <tr>
                <td>{{ $d->user_id }}</td>
                <td>{{ $d->username }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->level_id }}</td>
                <td>{{ $d->level->level_kode }}</td>
                <td>{{ $d->level->level_nama }}</td>
                <td><a href="{{ route('ubah', ['id' => $d->user_id]) }}">Ubah</a> | <a href="{{ route('hapus', ['id' => $d->user_id]) }}">Hapus</a></td>
            </tr>
        @endforeach

        {{-- <tr>
            <td>{{ $data->user_id }}</td>
            <td>{{ $data->username }}</td>
            <td>{{ $data->nama }}</td>
            <td>{{ $data->level_id }}</td>
        </tr> --}}

        {{-- untuk menentukan jumlah data  --}}
        {{-- <tr>
            <td>Jumlah Pengguna</td>
        </tr>
        <tr>
            <td>{{$data}}</td>
        </tr> --}}
    </table>
</body>
</html>