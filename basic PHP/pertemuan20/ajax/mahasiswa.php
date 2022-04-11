<!-- <h1>Hello World!</h1> -->

<?php


// ketika data diminta dari perintah ajax, kita sleep dulu , supaya bisa menvisualiasikan loader;
// untuk sleep
// sleep(1);

// untuk micro second sleep , 1000000 = 1 detik;
usleep(500000);

require '../functions.php';

$keyword = $_GET["keyword"];
$query = $query = "SELECT * FROM mahasiswa WHERE
                    nama LIKE '%$keyword%' OR
                    nim LIKE '%$keyword%' OR
                    jurusan LIKE '%$keyword%' OR
                    email LIKE '%$keyword%' 
                    ";
$mahasiswa = query($query);

// var_dump($mahasiswa);
?>
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