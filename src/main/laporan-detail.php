<?php
include '../connect.php';

session_start();

$cariPengaduan = mysqli_query($conn, "SELECT * FROM pengaduan WHERE id_pengaduan='" . $_GET['id'] . "'");
$pengaduanMentah = mysqli_fetch_assoc($cariPengaduan);
$idPengaduan = $pengaduanMentah['id_pengaduan'];

$cariDataPelapor = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik ='" . $pengaduanMentah['nik'] . "'");
$dataPelapor = mysqli_fetch_assoc($cariDataPelapor);

$cariIdTanggapan = mysqli_query($conn, "SELECT MAX(id_tanggapan) AS max_id FROM tanggapan");
$idTanggapanMentah = mysqli_fetch_assoc($cariIdTanggapan);
$idTanggapan = $idTanggapanMentah['max_id'] ? $idTanggapanMentah['max_id'] + 1 : 1000;

$usernamePetugas = $_SESSION['username'];

$cariPetugas = mysqli_query($conn, "SELECT * FROM petugas WHERE username='$usernamePetugas'");
$petugasMentah = mysqli_fetch_assoc($cariPetugas);
$idPetugas = $petugasMentah['id_petugas'];

// $result = mysqli_query($conn, "INSERT INTO pengaduan(id_pengaduan, tgl_pengaduan, isi_laporan, nik, status) VALUES('$id', '$waktu', '$laporan', '$nik', '0')");  

// if (!$result) {
//     die("Query error: " . mysqli_error($conn));
// }

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['proses'])) {
        mysqli_query($conn, "UPDATE pengaduan SET status='proses' WHERE id_pengaduan='" . $pengaduanMentah['id_pengaduan'] . "'");

        header("location:laporan-detail.php?id=" . $_GET['id']);
    }

    if (isset($_POST['selesai'])) {
        mysqli_query($conn, "UPDATE pengaduan SET status='selesai' WHERE id_pengaduan='" . $pengaduanMentah['id_pengaduan'] . "'");

        header("location:laporan-detail.php?id=" . $_GET['id']);
    }

    if (isset($_POST['beri_tanggapan'])) {
        $tanggapan = $_POST['tanggapan'];
        
        date_default_timezone_set("Asia/Jakarta");
        $tanggalTanggapan = date("Y-m-d");

        mysqli_query($conn, "INSERT INTO tanggapan (id_tanggapan, id_pengaduan, tgl_tanggapan, tanggapan, id_petugas) VALUES ('$idTanggapan', '$idPengaduan', '$tanggalTanggapan', '$tanggapan', '$idPetugas')");

        header("location:laporan-detail.php?id=" . $_GET['id']);
    }

    if (isset($_POST['invalid'])) {
        mysqli_query($conn, "DELETE FROM pengaduan WHERE id_pengaduan='" . $idPengaduan['id_pengaduan'] . "'");

        header("location:laporan.php");
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <?php
    include './navbar_admin.php';
    ?>

    <div class="m-8">
        <div class="flex items-center justify-center">
            <div class="border border-slate-300 rounded-xl shadow px-5 pt-5 pb-10">
                <h1 class="text-3xl font-medium text-center mb-5">
                    Laporan
                </h1>
                <div class="flex gap-96 mb-5">
                    <div>
                        <h2 class="font-medium">Tanggal Pelaporan</h2>
                        <h2 class="ml-3"><?= $pengaduanMentah['tgl_pengaduan']; ?></h2>
                    </div>
                    <div>
                        <h2 class="font-medium">ID Pengaduan</h2>
                        <h2 class="ml-3"><?= $pengaduanMentah['id_pengaduan'] ?></h2>
                    </div>
                </div>
                <div class="mb-5">
                    <h2 class="font-medium">Identitas Pelapor</h2>
                    <div class="ml-3">
                        <h2>NIK: <?= $dataPelapor['nik'] ?></h2>
                        <h2>Nama: <?= $dataPelapor['nama'] ?></h2>
                        <h2>Username: <?= $dataPelapor['username'] ?></h2>
                        <h2>No. Telepon: <?= $dataPelapor['telp'] ?></h2>
                    </div>
                </div>
                <div class="mb-5">
                    <h2 class="font-medium">Isi Pengaduan</h2>
                    <p class="ml-3 w-153"><?= $pengaduanMentah['isi_laporan'] ?></p>
                </div>
                <div class="mb-5">
                    <h2 class="font-medium">Foto</h2>
                    <h2 class="ml-3 ">Pelapor tidak menambahkan foto.</h2>
                </div>
                <div class="flex justify-between">
                    <?php
                    $status_raw = $pengaduanMentah['status'];

                    switch ($status_raw) {
                        case 0:
                            $warna = "yellow";
                            $status = "Belum terverifikasi";
                            break;
                        case "proses":
                            $warna = "blue";
                            $status = "Proses";
                            break;
                        case "selesai":
                            $warna = "green";
                            $status = "Selesai";
                            break;
                    }
                    ?>

                    <?php if ($status == "Belum terverifikasi"): ?>
                        <div class="flex items-center text-<?= $warna ?>-600">
                            <span class="w-3 h-3 bg-<?= $warna ?>-400 rounded-full mr-2"></span>
                            <?= $status ?>
                        </div>
                        <form class="flex gap-2" method="post">
                            <button type="submit" name="proses" id="proses"
                                class="bg-blue-500 px-4 py-1 text-white font-medium rounded-md cursor-pointer">Proses</button>
                            <button type="submit" name="invalid" id="invalid"
                                class="bg-red-500 px-4 py-1 text-white font-medium rounded-md cursor-pointer">Invalid</button>
                        </form>
                    <?php endif;

                    if ($status == "Proses"): ?>
                        <div class="flex items-center text-<?= $warna ?>-600">
                            <span class="w-3 h-3 bg-<?= $warna ?>-400 rounded-full mr-2"></span>
                            <?= $status ?>
                        </div>
                        <form class="flex gap-2" method="post">
                            <button type="submit" name="selesai" id="selesai"
                                class="bg-green-600 px-4 py-1 text-white font-medium rounded-md cursor-pointer">Selesai</button>
                            <button type="submit" name="invalid" id="invalid"
                                class="bg-red-500 px-4 py-1 text-white font-medium rounded-md cursor-pointer">Invalid</button>
                        </form>
                    <?php endif;

                    if ($status == "Selesai"): ?>
                        <form class="" method="post">
                    </div>
                    <div class="mt-5">
                        <h2 class="font-medium">Tanggapan</h2>
                        <textarea
                            class="resize-none border border-gray-300 rounded-md mt-2 w-full bg-gray-50 p-3 focus:outline-1"
                            type="text" name="tanggapan" id="tanggapan" rows="9"
                            placeholder="Ketik tanggapan di sini"></textarea>
                    </div>
                    <div class="flex justify-between mt-5">
                        <div class="flex items-center text-<?= $warna ?>-600">
                            <span class="w-3 h-3 bg-<?= $warna ?>-400 rounded-full mr-2"></span>
                            <?= $status ?>
                        </div>
                        <button type="submit" name="beri_tanggapan" id="beri_tanggapan"
                            class="bg-green-600 px-8 py-1 text-white font-medium rounded-md cursor-pointer">Beri
                            Tanggapan
                        </button>
                    </div>
                    </form>
                <?php endif; 

                if ($status == "Selesai"): ?>
                        <form class="" method="post">
                    </div>
                    <div class="mt-5">
                        <h2 class="font-medium">Tanggapan</h2>
                        <textarea
                            class="resize-none border border-gray-300 rounded-md mt-2 w-full bg-gray-50 p-3 focus:outline-1"
                            type="text" name="tanggapan" id="tanggapan" rows="9"
                            placeholder="Ketik tanggapan di sini"></textarea>
                    </div>
                    <div class="flex justify-between mt-5">
                        <div class="flex items-center text-<?= $warna ?>-600">
                            <span class="w-3 h-3 bg-<?= $warna ?>-400 rounded-full mr-2"></span>
                            <?= $status ?>
                        </div>
                        <button type="submit" name="beri_tanggapan" id="beri_tanggapan"
                            class="bg-green-600 px-8 py-1 text-white font-medium rounded-md cursor-pointer">Beri
                            Tanggapan
                        </button>
                    </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="bg-red-700 text-white mt-10 py-4 text-center text-sm">
        <p>Lapor</p>
        <p class="font-bold text-xl">PPM</p>
        <p>Kelompok 6<br>XI RPL-2</p>

    </div>

</body>

</html>