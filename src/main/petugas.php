<?php
include '../connect.php';
include './navbar_admin.php';

$id = $_SESSION['id']['id_petugas'];

$cariPetugas = mysqli_query($conn, "SELECT * FROM petugas WHERE id_petugas='$id'");
$petugasMentah = mysqli_fetch_assoc($cariPetugas)
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->

</head>

<body class="">

    <div class="mx-15 my-8">
        <div>
            <h1 class="text-3xl font-medium">Selamat Datang, <?= $petugasMentah['username']; ?>, di Page Petugas</h1>
            <h2 class="text-2xl">Selamat Bekerja.</h2>
        </div>

        <div class="mt-15">
            <div>
                <h1 class="mb-6 text-3xl font-medium">
                    Laporan
                </h1>
                <div class="grid grid-cols-2 gap-5">
                    <?php
                    $data = mysqli_query($conn, "SELECT * FROM pengaduan ORDER BY id_pengaduan DESC LIMIT 0, 12");
                    ?>

                    <div class="border border-gray-300 rounded-lg shadow overflow-hidden">
                        <div class="h-[500px] overflow-y-scroll space-y-4 p-4">
                            <?php foreach ($data as $item): ?>
                                <div
                                    class="border border-gray-400 p-4 rounded-lg shadow-sm h-[150px] flex flex-col justify-between">
                                    <div>
                                        <div class="flex justify-between items-center">
                                            <?php
                                            $nama_result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik='" . $item['nik'] . "'"));
                                            $nama = $nama_result['nama'];
                                            ?>
                                            <h2 class="font-medium text-xl"><?= $nama ?></h2>
                                            <span class="text-md text-gray-500"><?= $item['tgl_pengaduan'] ?></span>
                                        </div>
                                        <p class="text-md text-gray-700 mt-2 line-clamp-2">
                                            <?= $item['isi_laporan'] ?>
                                        </p>
                                    </div>
                                    <div class="flex mt-2 text-md font-medium justify-between">
                                        <a href="laporan-detail.php?id=<?= $item['id_pengaduan'] ?>"
                                            class="text-blue-500">Lihat Detail ›</a>
                                        <?php
                                        $status_raw = $item['status'];

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
                                        <div class="flex items-center text-<?= $warna ?>-600">
                                            <span class="w-3 h-3 bg-<?= $warna ?>-400 rounded-full mr-2"></span>
                                            <?= $status ?>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                        <div class="border-t px-4 py-3 text-center bg-white">
                            <a href="./laporan.php"
                                class="text-blue-500 font-semibold text-sm hover:underline flex items-center justify-center mx-auto">
                                Lihat Lebih Banyak
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="rounded-lg shadow overflow-hidden bg-red-700 p-5">
                        <h1 class="text-white font-medium text-3xl">Statistik Laporan</h1>
                        <div class="grid grid-cols-3 gap-5 text-white font-medium mt-5 h-5/12">
                            <div class="bg-yellow-400 p-3 rounded-xl grid gap-5">
                                Belum terverifikasi
                                <h1 class="text-center text-7xl">
                                    <?php
                                    $belum = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pengaduan WHERE status='0'"));
                                    echo $belum;
                                    ?>
                                </h1>
                                <a href="laporan.php?kategori=belum-terverifikasi">Lihat Detail ›</a>
                            </div>
                            <div class="bg-blue-400 p-3 rounded-xl grid gap-5">
                                Proses
                                <h1 class="text-center text-7xl">
                                    <?php
                                    $proses = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pengaduan WHERE status='proses'"));
                                    echo $proses;
                                    ?>
                                </h1>
                                <a href="laporan.php?kategori=proses">Lihat Detail ›</a>
                            </div>
                            <div class="bg-green-500 p-3 rounded-xl grid gap-5">
                                Selesai
                                <h1 class="text-center text-7xl">
                                    <?php
                                    $selesai = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pengaduan WHERE status='selesai'"));
                                    echo $selesai;
                                    ?>
                                </h1>
                                <a href="laporan.php?kategori=selesai">Lihat Detail ›</a>
                            </div>
                        </div>
                        <div class="bg-red-500 mt-5 h-5/12 rounded-xl text-white font-medium p-5 grid gap-5">
                            <h1 class="text-2xl -mb-10">
                                Total
                            </h1>
                            <div class="flex justify-center items-end mb-2 ">
                                <h1 class="text-center text-7xl">
                                    <?php
                                    echo $belum + $proses + $selesai;
                                    ?>
                                </h1>
                                <h3 class="text-xl ml-1">
                                    Laporan
                                </h3>
                            </div>
                            <a href="laporan.php" class="">Lihat Detail ›</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-15">
                <h1 class="mb-6 text-3xl font-medium">
                    Anggota
                </h1>
                <div class="grid grid-cols-2 gap-5">
                    <?php
                    $anggota = mysqli_query($conn, "SELECT * FROM petugas");
                    ?>

                    <div class="border border-gray-300 rounded-lg shadow overflow-hidden">
                        <div class="h-[500px] overflow-y-scroll space-y-4 p-4">
                            <?php foreach ($anggota as $arr_anggota): ?>
                                <div
                                    class="border border-gray-400 p-4 rounded-lg shadow-sm h-[100px] flex flex-col justify-between">
                                    <div>
                                        <div class="flex justify-between items-center">
                                            <h2 class="font-medium text-xl"><?= $arr_anggota['nama_petugas'] ?></h2>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center mt-2 text-md font-medium">
                                        <a href="anggota-detail.php?id=<?= $arr_anggota['id_petugas'] ?>"
                                            class="text-blue-500">Lihat Detail ›</a>
                                        <?php
                                        switch ($arr_anggota['level']) {
                                            case "admin":
                                                $warna_level = "blue";
                                                $level = "Admin";
                                                break;
                                            case "petugas":
                                                $warna_level = "green";
                                                $level = "Petugas";
                                                break;
                                        }
                                        ?>
                                        <div class="flex items-center text-<?= $warna_level ?>-600">
                                            <?= $level ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="border-t px-4 py-3 text-center bg-white">
                            <a href="./anggota.php">
                                <button
                                    class="text-blue-500 font-semibold text-sm hover:underline flex items-center justify-center mx-auto cursor-pointer">
                                    Lihat Lebih Banyak
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="rounded-lg shadow overflow-hidden bg-red-700 p-5">
                        <h1 class="text-white font-medium text-3xl">Statistik Anggota</h1>
                        <div class="grid grid-cols-2 gap-5 text-white font-medium mt-5 h-5/12">
                            <div class="bg-blue-400 p-3 rounded-xl grid gap-5">
                                Admin
                                <h1 class="text-center text-7xl">
                                    <?php
                                    $admin = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM petugas WHERE level='admin'"));
                                    echo $admin;
                                    ?>
                                </h1>
                                <a href="anggota.php?level=admin" class="">Lihat Detail ›</a>
                            </div>
                            <div class="bg-green-500 p-3 rounded-xl grid gap-5">
                                Petugas
                                <h1 class="text-center text-7xl">
                                    <?php
                                    $petugas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM petugas WHERE level='petugas'"));
                                    echo $petugas;
                                    ?>
                                </h1>
                                <a href="anggota.php?level=petugas" class="">Lihat Detail ›</a>
                            </div>
                        </div>
                        <div class="bg-red-500 mt-5 h-5/12 rounded-xl text-white font-medium p-5 grid gap-5">
                            <h1 class="text-2xl -mb-10">
                                Total
                            </h1>
                            <div class="flex justify-center items-end mb-2 ">
                                <h1 class="text-center text-7xl">
                                    <?php
                                    echo $admin + $petugas;
                                    ?>

                                </h1>
                                <h3 class="text-xl ml-1">
                                    Anggota
                                </h3>
                            </div>
                            <a href="anggota.php" class="">Lihat Detail ›</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include './footer.php';
    ?>
</body>

</html>