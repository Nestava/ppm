<?php
include '../connect.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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

        $foto = upload(); 

        if ($foto === 'invalid') {
            header("location: masyarakat.php?pesan=ekstensi_error");
            exit;
        }

        $nik = is_array($_SESSION['nik']) ? $_SESSION['nik']['nik'] : $_SESSION['nik'];

        $result = mysqli_query($conn, "INSERT INTO pengaduan(id_pengaduan, tgl_pengaduan, isi_laporan, nik, status, foto)  VALUES('$id', '$waktu', '$laporan', '$nik', '0', '$foto')");

        if ($result) {
            header("location: masyarakat.php?pesan=berhasil");
        } else {
            header("location: masyarakat.php?pesan=gagal_query");
        }
        exit;
    }
}

function upload()
{
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    if ($error === 4) {
        return 'default.jpg';
    }

    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    $ekstensiValid = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($ekstensiGambar, $ekstensiValid)) {
        return 'invalid';
    }

    $namaFileBaru = uniqid() . '.' . $ekstensiGambar;
    move_uploaded_file($tmpName, '../assets/img/' . $namaFileBaru);

    return $namaFileBaru;
}
?>