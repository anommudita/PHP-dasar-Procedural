<?php
// kita cek apakah user sudah berhasil login apa belum / sessionnya sudah dijalankan apa belum
// jika belum login akan ditendang di halaman login
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
require 'functions.php';
// menangkap didalam id dari url$_GET;
$id = $_GET["id"];
// Popup sesuai dengan intruksi salah atau benar;
if (hapus($id) > 0) {
    echo "<script>
            alert('data berhasil dihapus');
            document.location.href = 'index.php';
    </script>
    ";
} else {
    echo "<script>
            alert('data berhasil dihapus');
            document.location.href = 'index.php';
    </script>
    ";
}
