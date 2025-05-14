<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "pengaduan_pelaporan_masyarakat";

$conn = mysqli_connect($hostname, $username, $password, $database);

if ($conn->connect_errno) {
    die("Koneksi gagal :" . $conn->connect_error);
}
