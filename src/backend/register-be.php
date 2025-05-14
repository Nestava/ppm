<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nik = $_POST['nik'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $telepon = $_POST['telepon'];   
    $password = md5($_POST['password']);
    $con_password = md5($_POST['con-password']);

    if (empty($nik) || empty($name) || empty($username) || empty($telepon) || empty($password) || empty($con_password)) {
        header("location:register-fe.php?pesan=input_error");
        exit;
    }

    if ($password != $con_password) {
        header("location:register-fe.php?pesan=password_error");
        exit;
    }

    mysqli_query($conn, "INSERT INTO masyarakat (nik, nama, username, password, telp) VALUES ('$nik', '$name', '$username', '$password', '$telepon');");

    header("location:register-fe.php?pesan=register_berhasil");

    session_start();

    $_SESSION['username'] = $username;
    $_SESSION['nik'] = $nik;
    $_SESSION['status'] = "login";
    header("location:../main/masyarakat.php");


}

?>