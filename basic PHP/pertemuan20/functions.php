<?php
// koneksi ke database;
$link = mysqli_connect("localhost", "root", "", "phpdasar");

// menangkap perintah query;
// Read()
function query($query)
{
    // scope global supaya biasa memanggil $link dan tidak ditimpa;
    global $link;
    // result = lemari;
    // harus ada link dan string querynya;
    $result = mysqli_query($link, $query);

    // rows = kotak kosong yang akan dimasukan baju dari lemari; 
    $rows = [];
    // row = baju yang akan diambil dari lemari
    while ($row = mysqli_fetch_assoc($result)) {

        $rows[] = $row;
    }
    return $rows;
}

// function insert
function tambah($data)
{
    // scope global supaya biasa memanggil $link dan tidak ditimpa;
    global $link;
    // ambil data dari $_POST tiap element dalam form;
    $nama = htmlspecialchars($data["nama"]);
    $nim = htmlspecialchars($data["nim"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $email =  htmlspecialchars($data["email"]);

    // upload gambar
    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    // query insert data
    $query = "INSERT INTO mahasiswa VALUES
            ('', '$nama', '$nim', '$jurusan', '$email', '$gambar')";

    mysqli_query($link, $query);
    // akan menjalankan query lalu memngembalikan nilai jika berhasil 1 jika gagal -1;
    return mysqli_affected_rows($link);
}

// function upload gambar;
function upload()
{
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES["gambar"]['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek gambar apakah belum diupload;

    if ($error === 4) {

        echo "
            <script>
                alert('Masukan gambar terlebih dahulu!!!');
            </script>
        ";

        return false;
    }

    // hanya gambar boleh upload buka script yang aneh";

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "
        <script>
            alert('yang anda upload bukan gambar!!!');
        </script>
    ";

        return false;
    }

    if ($ukuranFile > 1000000) {
        echo "
        <script>
        alert('ukuran gambar terlalu besar!!!');
        </script>
        ";
        return false;
    }



    // generate nama gambar baru;
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;


    // pengecekan gambar sudah berhasil diupload;
    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
    return $namaFileBaru;
}



// delete
function hapus($id)
{

    global $link;
    // query delete data
    $hapus = "DELETE FROM mahasiswa WHERE id = $id";
    mysqli_query($link, $hapus);
    // akan menjalankan query lalu memngembalikan nilai jika berhasil 1 jika gagal -1;
    return mysqli_affected_rows($link);
}

// function update
function ubah($data)
{
    // scope global supaya biasa memangil $link dan tidak ditimpa;
    global $link;
    // ambil data dari $_POST tiap element dalam form;
    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $nim =  htmlspecialchars($data["nim"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $email =  htmlspecialchars($data["email"]);

    $gambarLama = htmlspecialchars($data["gambarLama"]);
    // cek user akan pilih gambar baru atau tidak;
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    // query insert data
    // mengambil data lama dan ditimpa dengan data baru , jika data ada yang tidak diganti maka data lama yang akan ditimpa;
    $query = "UPDATE mahasiswa SET 
                nama = '$nama',
                nim = '$nim',
                jurusan = '$jurusan',
                email = '$email',
                gambar ='$gambar'
                WHERE id = $id
                ";
    mysqli_query($link, $query);
    // akan menjalankan query lalu memngembalikan nilai jika berhasil 1 jika gagal -1;
    return mysqli_affected_rows($link);
}

// functions cari!
function cari($keyword)
{
    // query read mencari;
    // LIKE = apapun dicari semua dari belakang dicari dan akan ditampil;
    // %keyword% = apapun depan dan belakang akan dicari;
    $query = "SELECT * FROM mahasiswa WHERE
                nama LIKE '%$keyword%' OR
                nim LIKE '%$keyword%' OR
                jurusan LIKE '%$keyword%' OR
                email LIKE '%$keyword%' 
                ";
    // memanfaat function query
    return query($query);
}

// function registrasi;
function registrasi($data)
{
    global $link;
    $username = strtolower(stripslashes($data["username"]));

    $password = mysqli_real_escape_string($link, $data["password"]);
    $password2 = mysqli_real_escape_string($link, $data["password2"]);

    // cek usernam apa sudah disi atau belum;
    $result = mysqli_query($link, "SELECT username FROM user WHERE username = '$username'");

    // jika fungsi bernilai true maka username sudah pernah dibuat;
    if (mysqli_fetch_assoc($result)) {

        echo "
            <script>
                alert('Username sudah terdaftar!');
            </script>
        ";

        return false;
    }

    if (empty(trim($username))) {

        return false;
    }
    // cek confirmasi password
    if ($password !== $password2) {

        echo "
            <script>
                alert('Konfrimasi password tidak sesuai!');
            </script>
        ";

        return false;
    }

    // encripsi paswword, php menggunakan password_hash dan jangan menggunakan MD5;
    // $password = md5($password);
    $password = password_hash($password, PASSWORD_DEFAULT);
    // var_dump($password);
    // die;


    // tambahkan userbaru ke database'
    mysqli_query($link, "INSERT INTO user VALUES('', '$username', '$password')");
    return mysqli_affected_rows($link);
}