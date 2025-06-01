<?php

include '../connect.php';
include './navbar_admin.php';

$cariPengaduan = mysqli_query($conn, "SELECT * FROM pengaduan WHERE id_pengaduan='" . $_GET['id'] . "'");
$pengaduanMentah = mysqli_fetch_assoc($cariPengaduan);

$cariDataPelapor = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik ='" . $pengaduanMentah['nik'] . "'");
$dataPelapor = mysqli_fetch_assoc($cariDataPelapor);

$cariIdTanggapan = mysqli_query($conn, "SELECT MAX(id_tanggapan) AS max_id FROM tanggapan");
$idTanggapanMentah = mysqli_fetch_assoc($cariIdTanggapan);

$id = $_SESSION['id']['id_petugas'];

$cariPetugas = mysqli_query($conn, "SELECT * FROM petugas WHERE id_petugas='$id'");
$petugasMentah = mysqli_fetch_assoc($cariPetugas);

$cariPetugasDB = mysqli_query($conn, "SELECT * FROM petugas WHERE id_petugas='$id'");
$petugasDBMentah = mysqli_fetch_assoc($cariPetugas);

$idTanggapan = $idTanggapanMentah['max_id'] ? $idTanggapanMentah['max_id'] + 1 : 1000;
$idPengaduan = $pengaduanMentah['id_pengaduan'];
$idPetugas = $petugasMentah['id_petugas'];
$namaPetugas = $petugasMentah['nama_petugas'];

?>

<script>
    function hilangkanPopup() {
        document.getElementById("popup").style.display = "none";
    }
</script>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <div id="popup" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white px-5 py-5 rounded-xl">
            <?php if (isset($_POST['invalid'])): ?>
                <h1 class="">Invalid berarti menghapus laporan ini. Apakah anda yakin?</h1>
                <div class="flex justify-end gap-2 mt-5">
                    <form method="post">
                        <button class="border-2 border-red-600 text-red-600 font-medium py-1 px-5 rounded-md cursor-pointer"
                            name="ya_hapus">Ya</button>
                        <button type="button"
                            class="border-2 border-green-600 text-green-600 font-medium py-1 px-3 rounded-md cursor-pointer"
                            onclick="hilangkanPopup()">Tidak</button>
                    </form>
                </div>
            <?php endif; ?>
            <?php if (isset($_POST['proses'])): ?>
                <h1 class="">Anda yakin akan memproses laporan ini?</h1>
                <div class="flex justify-end gap-2 mt-5">
                    <form method="post">
                        <button class="border-2 border-green-600 text-green-600 font-medium py-1 px-5 rounded-md cursor-pointer"
                            name="ya_proses">Ya</button>
                        <button type="button"
                            class="border-2 border-red-600 text-red-600 font-medium py-1 px-3 rounded-md cursor-pointer"
                            onclick="hilangkanPopup()">Tidak</button>
                    </form>
                </div>
            <?php endif; ?>
            <?php if (isset($_POST['selesai'])): ?>
                <h1 class="">Anda yakin ingin menyelesaikan laporan ini?</h1>
                <div class="flex justify-end gap-2 mt-5">
                    <form method="post">
                        <input type="hidden" name="tanggapan" value="<?= htmlspecialchars($_POST['tanggapan']) ?>">
                        <button class="border-2 border-green-600 text-green-600 font-medium py-1 px-5 rounded-md cursor-pointer"
                            name="ya_selesai">Ya</button>
                        <button type="button"
                            class="border-2 border-red-600 text-red-600 font-medium py-1 px-3 rounded-md cursor-pointer"
                            onclick="hilangkanPopup()">Tidak</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<?php

if (isset($_POST['ya_proses'])) {
    mysqli_query($conn, "UPDATE pengaduan SET status='proses' WHERE id_pengaduan='" . $pengaduanMentah['id_pengaduan'] . "'");

    header("location:laporan-detail.php?id=" . $_GET['id']);
}

if (isset($_POST['ya_selesai'])) {

    if (!empty($_POST['tanggapan'])) {

        $tanggapan = $_POST['tanggapan'];

        date_default_timezone_set("Asia/Jakarta");
        $tanggalTanggapan = date("Y-m-d");

        mysqli_query($conn, "INSERT INTO tanggapan (id_tanggapan, id_pengaduan, tgl_tanggapan, tanggapan, id_petugas) VALUES ('$idTanggapan', '$idPengaduan', '$tanggalTanggapan', '$tanggapan', '$idPetugas')");

        mysqli_query($conn, "UPDATE pengaduan SET status='selesai' WHERE id_pengaduan='" . $pengaduanMentah['id_pengaduan'] . "'");

        header("location:laporan-detail.php?id=" . $_GET['id']);
        exit;
    } else {
        header("location:laporan-detail.php?id=" . $_GET['id'] . "&error=tanggapan_kosong");
        exit;
    }
}

if (isset($_POST['ya_hapus'])) {
    mysqli_query($conn, "DELETE FROM pengaduan WHERE id_pengaduan='" . $pengaduanMentah['id_pengaduan'] . "'");

    header("location:laporan.php");
}

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
                        <div class="">
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
                        <p class="ml-3 w-153"><?= nl2br($pengaduanMentah['isi_laporan']) ?></p>
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
                            <form class="flex gap-2" method="post">
                                <button type="submit" name="proses" id="proses"
                                    class="bg-blue-500 px-4 py-1 text-white font-medium rounded-md cursor-pointer">Proses</button>
                                <button type="submit" name="invalid" id="invalid"
                                    class="bg-red-500 px-4 py-1 text-white font-medium rounded-md cursor-pointer">Invalid</button>
                            </form>
                        </div>
                    <?php endif;

                        if ($status == "Proses"): ?>
                        <form class="" method="post">
                    </div>
                    <div class="mt-5">
                        <h2 class="font-medium">Tanggapan</h2>
                        <?php
                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == "tanggapan_kosong") {
                                echo "<h1 class='text-red-500 text-center'>Tanggapan tidak boleh kosong.</h1>";
                            }
                        }
                        ?>
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
                        <div class="flex gap-2">
                            <button type="submit" name="selesai" id="selesai"
                                class="bg-green-600 px-8 py-1 text-white font-medium rounded-md cursor-pointer">
                                Selesai
                            </button>
                            <button type="submit" name="invalid" id="invalid"
                                class="bg-red-500 px-4 py-1 text-white font-medium rounded-md cursor-pointer">Invalid</button>
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
                    <form class="" method="post">
                </div>
                <div class="mb-5">
                    <h2 class="font-medium">Tanggapan</h2>
                    <p class="ml-3 w-153"><?= nl2br($tanggapanDB); ?></p>
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
                    <div class="flex gap-2">
                        <a href="generate-laporan.php?id=<?= $pengaduanMentah['id_pengaduan'] ?>" target="_blank"
                            class="bg-yellow-400 px-8 py-1 text-black font-medium rounded-md cursor-pointer">
                            Generate Laporan
                        </a>
                    </div>
                </div>
                </form>
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

</body>

</html>