<?php
// kita cek apakah user sudah berhasil login apa belum / sessionnya sudah dijalankan apa belum
// jika belum login akan ditendang di halaman login
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

// Mengubungkan/memanggil ke file functions;
require 'functions.php';

// pagination 
// konfigurasinya

$jumlahdataperhalaman = 2;
// cara menghitung jumlah data perhalaman;
// jumlah halaman = total data / data perhalaman;

$result = mysqli_query($link, "SELECT * FROM mahasiswa ");

// ambil semua data mahasiswa dan menghasilkan beberapa baris yang dikembalikan oleh tabel mahasiswa 
// $jumlahdata = mysqli_num_rows($result);
// count = untuk menghitung ada beberapa element yang ada array apapun;
$jumlahdata = count(query("SELECT * FROM mahasiswa"));

// jumlah halaman;
// round = membulatkan bilangan pecahan desimal terdekatnya nya jika smpai 1,5 maka bilangan akan naik keatas;
// floor = untuk membulatkan bilangan desimal menjadi angka ke bawah , floor = tangga atau turun;
// ceil = untuk membulatkan bilangan desimal menjadi angka ke atas, dan ceil artinya ke langit- langit = keatas
$jumlahHalaman = ceil($jumlahdata / $jumlahdataperhalaman);


// halaman yang aktif atau kita berada dihalaman keberapa;
// jika masuk lagi ke index akan eror karena kita minta halamannya lngsung;

// if (isset($_GET["page"])) {

//     $halamanAktif = $_GET["page"];
// } else {

//     $halamanAktif = 1;
// }

// tidak menggunakan perkondisian , jadi menggunakan operator tenary biar lebih simple buatnya;
//  ? = jika kndisi true maka halaman aktif disiin oleh $_GET"page" jika tika : beri angka 1;
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

// halaman = 2 , Awaldata = 2
// halaman = 3 , awalData = 4 
$awaldata = ($jumlahdataperhalaman * $halamanAktif) - $jumlahdataperhalaman;

// var_dump($halamanAktif);

///perintah query ada di di functions;
// urutkan berdasarkan apa ?, misalnya memasukan data baru akan mucul diatas maka sebaliknya ( ORDER BY id ASC(menaik) atau DESC(menurun)) 
$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awaldata, $jumlahdataperhalaman");

// jika tombol <cari>diklik maka timpa $mahasiswa sesuai dengan data dicari 
if (isset($_POST["cari"])) {
    // cari data sesuai keyword yang dicari;
    // data mahasiswa ditimpa dengan functions cari;
    $mahasiswa = cari($_POST["keyword"]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link rel="shorcut icon" type="image/png" href="img/heart.png" />

    <!-- loader -->
    <style>
    .loader {

        width: 100px;

        position: absolute;
        top: 106px;
        left: 280px;
        /* fungsi z-index ke belakang latar belakangnya */
        z-index: -1;
        display: none;
    }
    </style>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
</head>

<body>

    <!-- logout -->
    <a href="logout.php">logout!</a>
    <br>
    <h1>Daftar Mahasiswa</h1>
    <a href="tambah.php">Tambah data mahasiswa</a>
    <br>
    <br>
    <!-- from untuk mencari -->
    <!-- autocomplete = membershikan histrory -->
    <!-- autofocus = langsung focus ke pencarian; -->
    <!-- jika <form action> dihapus maka data akan dikirim dihalaman ini;  -->
    <form method="post">
        <input type="text" name="keyword" placeholder="ketik disini.." size="40" autofocus autocomplete="off"
            id="keyword">
        <button type="submit" name="cari" id="tombol-cari">cari!</button>

        <img src="img/loader.gif" class="loader">
    </form>
    <br>
    <!-- navigasi halaman -->

    <!-- perkondisian untuk tidak ke halaman 0 dan tanda previous akan dimatikan; -->
    <?php if ($halamanAktif > 1) : ?>
    <a href="?page=<?= $halamanAktif - 1; ?>">&laquo;</a>
    <?php endif; ?>

    <!-- menggunkana perulangan -->
    <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
    <!-- perkondisian untuk ngebold halaman yang sedang aktif -->
    <?php if ($i == $halamanAktif) : ?>

    <a href="?page=<?= $i; ?>" style="font-weight: bold; color:red;"><?= $i; ?></a>

    <?php else : ?>

    <!-- jika bukan halaman aktif akan menampilkan angka hal seperti biasa -->
    <a href="?page=<?= $i; ?>"><?= $i; ?></a>

    <?php endif; ?>
    <?php endfor; ?>

    <!-- perkondisian untuk tidak ke halaman max dan tanda next akan dimatikan; -->
    <?php if ($halamanAktif < $jumlahHalaman) : ?>
    <a href="?page=<?= $halamanAktif + 1; ?>">&raquo;</a>
    <?php endif; ?>

    <!-- akhir navigasi -->


    <br>

    <!-- Tempat menampung sumber untuk ajax , supaya dikembalikan oleh ajax -->
    <div id="container">
        <!-- tabel -->
        <table border="1" cellpadding="10" cellspasing="0">
            <!-- header tabel-->
            <tr>
                <th>NO.</th>
                <th>Aksi</th>
                <th>Nama</th>
                <th>NIM</th>
                <th>Jurusan</th>
                <th>Email</th>
                <th>Gambar</th>
            </tr>
            <!-- isi row -->
            <?php $i = 1; ?>
            <?php foreach ($mahasiswa as $row) : ?>
            <tr>
                <td><?= $i; ?></td>
                <td><a href="ubah.php?id=<?= $row["id"] ?>">Ubah | </a>
                    <!-- js onclick ya nilai true akan dihapus jika false tidak dihapus -->
                    <a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('yakin dihapus?')">Hapus</a>
                </td>
                <td><?= $row["nama"]; ?></td>
                <td><?= $row["nim"]; ?></td>
                <td><?= $row["jurusan"]; ?></td>
                <td><?= $row["email"]; ?></td>
                <td><img src="img/<?= $row["gambar"]; ?>" width="100px" alt="<?= $row["gambar"]; ?>"></td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; ?>
        </table>
        <script src="js/jquery-3.6.0.min.js"></script>
    </div>


    <!-- include java scirpt -->
    <!-- html dulu diload baru JS nya; -->
    <!-- JQUERY -->
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>