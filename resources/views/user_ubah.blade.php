<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>user Ubah</title>
</head>
<body>
    <h1>Form Ubah Data User</h1>
    <a href="user">Kembali</a>
    <br><br>

    <form method="POST" action="{{ route('user.ubah_simpan', $data->user_id) }}">
        {{ csrf_field() }}
        {{ method_field('PUT')}}

        <label for="">Username</label>
        <input type="text" name="username" placeholder="Masukkan Username" value="{{ $data->username }}">
        <br>
        <label for="">Nama</label>
        <input type="text" name="nama" placeholder="Masukkan Nama" value="{{ $data->nama }}">
        <br>
        <label for="">Password</label>
        <input type="password" name="password" placeholder="Masukkan Password" value="{{ $data->password }}">
        <br>
        <label for="">Level ID</label>
        <input type="number" name="level_id" placeholder="Masukkan ID Level" value="{{ $data->level_id}}">
        <br>
        <br>
        <input type="submit" class="btn btn-success" value="Ubah">
    </form>
</body>
</html>