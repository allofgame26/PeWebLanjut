<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Data</title>
</head>
<body>
    <h1>Form Tambah Data User</h1>
    <form method="post" action="{{ route('tambah_simpan') }}">

        {{ csrf_field() }}

        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Masukkan Nama">
        <br>
        <label for="nama">Nama</label>
        <input type="text" name="nama" id="nama" placeholder="Masukkan Nama">
        <br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Password">
        <br>
        <label for="level_id">ID Level</label>
        <input type="number" name="level_id" id="level_id" placeholder="Masukkan ID Level">
        <br><br>
        <input type="submit" class="btn btn-success" value="Simpan">
    </form>
</body>
</html>