<?php
// kita cek apakah user sudah berhasil login apa belum / sessionnya sudah dijalankan apa belum
// jika belum login akan ditendang di halaman login
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
// Mengubungkan/memanggil ke file functions tambah; 
require 'functions.php';

// ambil data dari url
$id = $_GET["id"];
// query data mahasiswa berdasarkan id dan cukup sekali dielement 0, karena fungsi query arraynya dari index 0;
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];

// cek apakah tombol submit sudah ditekan atau belum 
if (isset($_POST["submit"])) {
    // cek apakah sudah berhasil ditambahkan atau tidak;
    // data from diambil oleh $_POST dan ditangkap oleh $data;
    // Popup sesuai dengan intruksi salah atau benar;
    if (ubah($_POST) > 0) {

        echo "<script>
                alert('data berhasil diubah');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "<script>
                alert('data gagal diubah');
                document.location.href = 'index.php';
            </script>
        ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Mahasiswa</title>
    <style>
        label {
            display: block;
        }
    </style>
    <link rel="shorcut icon" type="image/png" href="img/heart.png" />
</head>

<body>
    <h1>Ubah Data Mahasiswa</h1>

    <form method="post" enctype="multipart/form-data">
        <ul>
            <!-- element data id yang disembunyikan dan tidak diinput oleh user; -->
            <input type="hidden" name="id" value="<?= $mhs["id"]; ?>">
            <input type="hidden" name="gambarLama" value="<?= $mhs["gambar"]; ?>">
            <li>
                <label for="nama">Nama :</label>
                <input type="text" name="nama" id="nama" required value="<?= $mhs["nama"]; ?>">
            </li>
            <!-- value perintah html untuk memasukan nilai secara static; -->
            <li>
                <label for="nim">NIM :</label>
                <input type="text" name="nim" id="nim" value="<?= $mhs["nim"]; ?>">
            </li>
            <li>
                <label for="jurusan">Jurusan :</label>
                <input type="text" name="jurusan" id="jurusan" value="<?= $mhs["jurusan"]; ?>">
            </li>
            <li>
                <label for="email">Email :</label>
                <input type="text" name="email" id="email" value="<?= $mhs["email"]; ?>">
            </li>
            <li>
                <label for="gambar">Gambar :</label>
                <img src="img/<?= $mhs['gambar']; ?>" width="100px" alt="gambar"> <br>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="sumbit" name="submit">Ubah Data!</button>
            </li>
            <a href="index.php"> <img src="img/x-button.png" alt="cancel" width="40px"></a>
        </ul>
    </form>
</body>

</html>