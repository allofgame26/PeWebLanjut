<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Data</title>
</head>
<body>
    <h1>Form Update Data User</h1>
    <form method="post" action="{{ route('ubah_simpan', ['id' => $data->user_id]) }}">

        {{ csrf_field() }}
        {{ method_field('PUT')}}
        
        <label for="id">ID</label>
        <input type="text" name="'id" id="id" readonly="true" value="{{ $data->user_id }}">
        <br>
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Masukkan Nama" value="{{ $data->username }}">
        <br>
        <label for="nama">Nama</label>
        <input type="text" name="nama" id="nama" placeholder="Masukkan Nama" value="{{ $data->nama }}">
        <br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Masukkan Password">
        <br>
        <label for="level_id">ID Level</label>
        <input type="number" name="level_id" id="level_id" placeholder="Masukkan ID Level" value="{{ $data->level_id }}">
        <br><br>
        <input type="submit" class="btn btn-success" value="Ubah">
    </form>
</body>
</html>