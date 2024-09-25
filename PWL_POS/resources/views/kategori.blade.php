<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Kategori Barang</title>
</head>
<body>
    <h1>Data kategori Barang</h1>
    <table border="1" cellpadding="2" cellspadding="0">
        <tr>
            <th>ID</th>
            <th>Kode Kategori</th>
            <th>Nama Kategori</th>
        </tr>
        @foreach ($data as $d)
        <tr>
            <th>{{ $d->kategori_id }}</th>
            <th>{{ $d->kategori_kode }}</th>
            <th>{{ $d->kategori_nama }}</th>
        </tr>
        @endforeach
    </table>
</body>
</html>