<?php

include '../connect.php';
include './navbar.php';

$cariPengaduan = mysqli_query($conn, "SELECT * FROM pengaduan WHERE id_pengaduan='" . $_GET['id'] . "'");
$pengaduanMentah = mysqli_fetch_assoc($cariPengaduan);

$cariDataPelapor = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik ='" . $pengaduanMentah['nik'] . "'");
$dataPelapor = mysqli_fetch_assoc($cariDataPelapor);

$cariIdTanggapan = mysqli_query($conn, "SELECT MAX(id_tanggapan) AS max_id FROM tanggapan");
$idTanggapanMentah = mysqli_fetch_assoc($cariIdTanggapan);

$idTanggapan = $idTanggapanMentah['max_id'] ? $idTanggapanMentah['max_id'] + 1 : 1000;
$idPengaduan = $pengaduanMentah['id_pengaduan'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan</title>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
</head>

<body class="flex flex-col min-h-screen">
    <main class="flex-grow">
        <div class="md:m-8">
            <div class="md:flex items-center justify-center">
                <div class="md:border md:border-slate-300 rounded-xl md:shadow px-5 pt-5 pb-10">
                    <h1 class="text-2xl md:text-3xl font-medium text-center mb-5">
                        Laporan
                    </h1>
                    <div class="md:flex md:gap-96 mb-5">
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
                            <div class="md:flex md:gap-1">
                                <h2 class="font-medium">NIK: </h2> <?= $dataPelapor['nik'] ?>
                            </div>
                            <div class="md:flex md:gap-1">
                                <h2 class="font-medium">Nama: </h2> <?= $dataPelapor['nama'] ?>
                            </div>
                            <div class="md:flex md:gap-1">
                                <h2 class="font-medium">Username: </h2> <?= $dataPelapor['username'] ?>
                            </div>
                            <div class="md:flex md:gap-1">
                                <h2 class="font-medium">No. Telepon: </h2> <?= $dataPelapor['telp'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <h2 class="font-medium">Isi Pengaduan</h2>
                        <p class="ml-3 md:w-153"><?= nl2br($pengaduanMentah['isi_laporan']) ?></p>
                    </div>
                    <div class="mb-5">
                        <h2 class="font-medium">Foto</h2>
                        <?php if ($pengaduanMentah['foto'] === "default.jpg" || $pengaduanMentah['foto'] === null): ?>
                            <h2 class="ml-3">Pelapor tidak menambahkan foto.</h2>
                        <?php else: ?>
                            <img width="625px" src="../assets/img/<?= htmlspecialchars($pengaduanMentah['foto']); ?>"
                                alt="Foto Pengaduan">
                        <?php endif; ?>
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
                        </div>
                    <?php endif;

                        if ($status == "Proses"): ?>
                        <form class="" method="post">
                            <div class="flex justify-between mt-5">
                                <div class="flex items-center text-<?= $warna ?>-600">
                                    <span class="w-3 h-3 bg-<?= $warna ?>-400 rounded-full mr-2"></span>
                                    <?= $status ?>
                                </div>
                            </div>
                        </form>
                    <?php endif;

                        if ($status == "Selesai"): ?>


                        <?php
                        $cariTanggapanDB = mysqli_query($conn, "SELECT * FROM tanggapan WHERE id_pengaduan = '$idPengaduan'");
                        $tanggapanDBMentah = mysqli_fetch_assoc($cariTanggapanDB);
                        $tanggapanDB = $tanggapanDBMentah['tanggapan'];

                        $idPetugasDB = $tanggapanDBMentah['id_petugas'];

                        $petugas = mysqli_query($conn, "SELECT * FROM petugas WHERE id_petugas='$idPetugasDB'");
                        $dataPetugasMentah = mysqli_fetch_assoc($petugas);
                        ?>
                    </div>
                    <div class="mb-5">
                        <h2 class="font-medium">Tanggapan</h2>
                        <p class="ml-3 md:w-153"><?= nl2br($tanggapanDB); ?></p>
                    </div>
                    <div class="mb-5">
                        <h2 class="font-medium">Ditanggapi Oleh</h2>
                        <p class="ml-3"><?= $dataPetugasMentah['nama_petugas']; ?></p>
                    </div>
                    <div class="">
                        <h2 class="font-medium">Selesai Pada Tanggal</h2>
                        <p class="ml-3"><?= $tanggapanDBMentah['tgl_tanggapan']; ?></p>
                    </div>
                    <div class="flex justify-between mt-5">
                        <div class="flex items-center text-<?= $warna ?>-600">
                            <span class="w-3 h-3 bg-<?= $warna ?>-600 rounded-full mr-2"></span>
                            <?= $status ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        </div>
        </div>
        </div>
    </main>

    <?php
    include './footer.php';
    ?>

    </dy>

</html>