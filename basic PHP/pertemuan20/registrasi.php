<?php

require 'functions.php';

if (isset($_POST["register"])) {

    if (registrasi($_POST) > 0) {

        echo "
                <script>
                    alert('user baru berhasil ditambahkan!');
                </script>
            ";

        // header('Location: login.php');
        // exit;
    } else {
        echo mysqli_error($link);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <style>
        label {
            display: block;
        }
    </style>
    <link rel="shorcut icon" type="image/png" href="img/heart.png" />
</head>

<body>

    <H1>Halaman Registrasi</H1>

    <form action="" method="POST">


        <ul>
            <li>
                <label for="username">Username : </label>
                <input type="text" name="username" id="username">
            </li>

            <li>
                <label for="password">Password : </label>
                <input type="password" name="password" id="password">
            </li>

            <li>
                <label for="password2"> Confirm Password</label>
                <input type="password" name="password2" id="password2">
            </li>

            <li>
                <button type="submit" name="register" require>Register!</button>

            </li>

            <br>

            <a href="login.php">login dulu</a>

        </ul>



    </form>




</body>

</html>