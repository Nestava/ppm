<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    $laporan = $_POST['laporan'];
    $waktu = date("Y-m-d");

    $query = mysqli_query($conn, "SELECT MAX(id_pengaduan) AS max_id FROM pengaduan");
    $row = mysqli_fetch_assoc($query);
    $id = $row['max_id'] ? $row['max_id'] + 1 : 1000;

    $nik = is_array($_SESSION['nik']) ? $_SESSION['nik']['nik'] : $_SESSION['nik'];

    $result = mysqli_query($conn, "INSERT INTO pengaduan(id_pengaduan, tgl_pengaduan, isi_laporan, nik) VALUES('$id', '$waktu', '$laporan', '$nik')");

    if (!$result) {
        die("Query error: " . mysqli_error($conn));
    }

    header("location: masyarakat.php");
    exit;
}
;
?>