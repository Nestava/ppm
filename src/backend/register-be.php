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

    $validasi = mysqli_query($conn, "SELECT * FROM petugas WHERE username='$username'");
    $validasi2 = mysqli_query($conn, "SELECT * FROM masyarakat WHERE username='$username'");

    if (mysqli_num_rows($validasi) > 0 || mysqli_num_rows($validasi2) > 0) {
        header("location:register-fe.php?pesan=username-terpakai");
        exit;
    }

    $validasinik = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik='$nik'");

    if (mysqli_num_rows($validasinik) > 0) {
        header("location:register-fe.php?pesan=nik-terpakai");
        exit;
    }

    if ($password != $con_password) {
        header("location:register-fe.php?pesan=password_error");
        exit;
    }

    if (strlen($password) < 8) {
        header("location:register-fe.php?pesan=password_pendek");
        exit;
    }

    mysqli_query($conn, "INSERT INTO masyarakat (nik, nama, username, password, telp) VALUES ('$nik', '$name', '$username', '$password', '$telepon');");

    header("location:register-fe.php?pesan=register_berhasil");

    session_start();

    $_SESSION['nik'] = $nik;
    $_SESSION['status'] = "login";
    header("location:../main/masyarakat.php");


}

?>