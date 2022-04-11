<?php

// menghancur session supaya tidak masuk lagi halaman index;
session_start();

//  ditimpa dengan array kosong supaya aman dan ada beberapa kasus session masih belum dihancurkan , untuk jaga';
$_SESSION = [];
session_unset();
session_destroy();

// menghapus cookie;
// nilai harus disini kosong, karena untuk menghapus, 
// waktu harus dimundur supaya habis expired cookienya;
setcookie('id', '', time() - 3600);
setcookie('key', '', time() - 3600);

// tendang ke halaman login
header("Location: login.php");
exit;