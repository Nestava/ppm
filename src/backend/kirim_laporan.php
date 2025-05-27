<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
}

if (isset($_POST['submit'])) {
    $laporan = mysqli_real_escape_string($conn, $_POST['laporan']);

    if (empty($laporan)) {
        header("location: masyarakat.php?pesan=laporan_kosong");
        exit;
    }

    if (strlen($laporan) < 10) {
        header("location: masyarakat.php?pesan=laporan_tidak_valid");
        exit;
    }

    $waktu = date("Y-m-d");

    $query = mysqli_query($conn, "SELECT MAX(id_pengaduan) AS max_id FROM pengaduan");
    $row = mysqli_fetch_assoc($query);
    $id = $row['max_id'] ? $row['max_id'] + 1 : 1000;

    $nik = is_array($_SESSION['nik']) ? $_SESSION['nik']['nik'] : $_SESSION['nik'];

    $result = mysqli_query($conn, "INSERT INTO pengaduan(id_pengaduan, tgl_pengaduan, isi_laporan, nik, status) VALUES('$id', '$waktu', '$laporan', '$nik', '0')");

    header("location: masyarakat.php");
    exit;
}

;
?>