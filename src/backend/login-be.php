<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $queryMasyarakat = mysqli_query($conn, "SELECT * FROM masyarakat WHERE username='$username' AND password='$password'");
    if (mysqli_num_rows($queryMasyarakat) > 0) {
        $nik_find = mysqli_query($conn, "SELECT nik FROM masyarakat WHERE username='$username'");
        $nik = mysqli_fetch_assoc($nik_find);
        $_SESSION['username'] = $username;
        $_SESSION['nik'] = $nik;
        $_SESSION['status'] = "login";
        header("location:../main/masyarakat.php");
        exit;
    }

    $queryPetugas = mysqli_query($conn, "SELECT * FROM petugas WHERE username='$username' AND password='$password'");
    if (mysqli_num_rows($queryPetugas) > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['status'] = "login";
        header("location:../main/petugas.php");
        exit;
    }

    header("location:login-fe.php?pesan=gagal");
    exit;


    // $nik_find = mysqli_query($conn, "SELECT nik FROM masyarakat WHERE username='$username'");
    // $nik = mysqli_fetch_assoc($nik_find);

    // $cek = mysqli_num_rows($data);
    // if ($cek > 0) {
    //     $_SESSION['username'] = $username;
    //     $_SESSION['nik'] = $nik;
    //     $_SESSION['status'] = "login";
    //     header("location:../main/masyarakat.php");
    // } else {
    //     header("location:login-fe.php?pesan=gagal");
    // }
}


?>