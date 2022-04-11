<?php


// kita cek apakah user sudah berhasil login apa belum / sessionnya sudah dijalankan apa belum
// jika belum login akan ditendang di halaman login
session_start();
require 'functions.php';

// cek cookie supaya session bisa dijalankan sesuai dengan session , remember dulu dijalankan baru sessionnya;

// if (isset($_COOKIE['login'])) {

//     if ($_COOKIE['login'] == 'true') {

//         // kalau true kita set sessionnya;
//         $_SESSION['login'] = true;
//     }
// }

// cek cookie
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {


    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // ambil username berdasarkan idnya;
    $result = mysqli_query($link, "SELECT username FROM user WHERE id = $id");

    $row = mysqli_fetch_assoc($result);


    // cek cookie dan username
    // acak username baru sama dengan hashnya;
    if ($key === hash('sha256', $row['username'])) {


        $_SESSION['login'] = true;
    }
}


// cookie ada akan ke index;
if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}


// apakah tombol login sudah ditekan apa belum;
if (isset($_POST["login"])) {
    // mengambil data lewat post;
    $username = $_POST["username"];
    $password = $_POST["password"];

    // pengecekan username apakah sudah terdaftar didatabase;
    $result = mysqli_query($link, "SELECT * FROM user WHERE username='$username' a");


    // cek username 
    // jika hasilnya 1 maka ada usernam , dan lanjut pengecekan password
    if (mysqli_num_rows($result) === 1) {

        // cek password
        $row = mysqli_fetch_assoc($result);

        // menterjemahkan password string yang diacak;
        if (password_verify($password, $row["password"])) {

            // set dulu sessionya
            $_SESSION["login"] = true;

            // cek remember me
            if (isset($_POST['remember'])) {

                // buat cookie
                // setcookie('login', 'true', time() + 60);
                setcookie('id', $row['id'], time() + 60);
                // cari didocument php password hash untuk enkripsi pasword atau mengenerate;
                setcookie('key', hash('sha256', $row['username']), time() + 60);
            }

            header("Location: index.php");
            exit;
        }
    }
    // jika eror maka keluar dari kondisi;
    $error = true;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <style>
    labeli {

        display: block;
    }
    </style>

    <link rel="shorcut icon" type="image/png" href="img/heart.png" />
</head>

<body>
    <H1>Halaman Login </H1>
    <!-- jika ada eror maka memunculkan tulisan ini -->
    <?php if (isset($error)) : ?>
    <p style="color:red; font-style:italic">username / password yang anda masukan salah</p>

    <?php endif; ?>

    <form action="" method="POST">

        <ul>

            <li>
                <labeli for="username">Username: </labeli>
                <input type="text" name="username" id="username">
            </li>

            <li>
                <labeli for="password">Password :</labeli>
                <input type="password" name="password" id="password">
            </li>

            <li>
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember me</label>


            </li>

            <li>
                <button type="sumbit" name="login">Login!</button>
            </li>

            <br>
            <a href="registrasi.php">daftar dulu!</a>
        </ul>
    </form>

</body>

</html>