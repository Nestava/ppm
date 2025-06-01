<?php

include '../connect.php';
include './navbar.php';

$nik = $_SESSION['nik'];

//

$limit = 12;

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$total_data_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pengaduan WHERE nik='$nik'");
$total_data = mysqli_fetch_assoc($total_data_result)['total'];
$total_pages = ceil($total_data / $limit);

//

$cariData = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik='$nik'");
$data = mysqli_fetch_assoc($cariData);

$id = $data['nik'];
$nama = $data['nama'];
$username = $data['username'];
$telp = $data['telp'];
$password = $data['password'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['submit_nama'])) {
        $newUsername = $_POST['username'];
        if (empty($newUsername)) {
            header("location:profil-masyarakat.php?error=data_kosong");
            exit;
        }
        $validasi = mysqli_query($conn, "SELECT * FROM petugas WHERE username='$newUsername'");
        $validasi2 = mysqli_query($conn, "SELECT * FROM masyarakat WHERE username='$newUsername'");

        if (mysqli_num_rows($validasi) > 0 || mysqli_num_rows($validasi2) > 0) {
            header("location:profil-masyarakat.php?error=username_terpakai");
            exit;
        }

        mysqli_query($conn, "UPDATE masyarakat SET username='$newUsername' WHERE nik='$id'");
        header("location:profil-masyarakat.php?perubahan_berhasil");
        exit;
    }

    if (isset($_POST['submit_telp'])) {
        $newTelepon = $_POST['telepon'];
        if (empty($newTelepon)) {
            header("location:profil-masyarakat.php?error=data_kosong");
            exit;
        }

        mysqli_query($conn, "UPDATE masyarakat SET telp='$newTelepon' WHERE nik='$id'");
        header("location:profil-masyarakat.php?perubahan_berhasil");
        exit;
    }
    if (isset($_POST['submit_pass'])) {
        if (empty($_POST['password']) || empty($_POST['konfirm_password'])) {
            header("location:profil-masyarakat.php?error=data_kosong");
            exit;
        }

        if (strlen($_POST['password']) < 8 || strlen($_POST['konfirm_password']) < 8) {
            header("location:profil-masyarakat.php?error=kurang_karakter");
            exit;
        }

        $newPassword = md5($_POST['password']);
        $conPassword = md5($_POST['konfirm_password']);
        if (strlen($_POST['password']) < 8) {
            header("location:profil-masyarakat.php?error=kurang_karakter");
            exit;
        } else if ($newPassword != $conPassword) {
            header("location:profil-masyarakat.php?error=konfirm_password");
            exit;
        } else if ($newPassword == $conPassword) {
            mysqli_query($conn, "UPDATE masyarakat SET password='$newPassword' WHERE nik='$id'");
            header("location:profil-masyarakat.php?perubahan_berhasil");
            exit;
        }
    }
}



$cariTanggapan = mysqli_query($conn, "SELECT * FROM pengaduan WHERE nik='$id' ORDER BY id_pengaduan DESC LIMIT $start, $limit; ");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> -->

    <style>
        input.no-spinner::-webkit-inner-spin-button,
        input.no-spinner::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input.no-spinner {
            -moz-appearance: textfield;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen">
    <main class="flex-grow">
        <main class="max-w-3xl mx-auto mt-5 md:p-6 bg-white md:shadow-md rounded-lg mb-10 md:border border-slate-300">
            <h1 class="text-2xl md:text-3xl font-medium text-center md:mb-8">Profil</h1>
            <div class="md:bg-gray-50 p-6 rounded-md md:border md:border-slate-300">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-1 md:gap-y-2 text-md text-gray-700">
                    <p class="font-medium">ID :</p>
                    <p><?= $id ?> </p>
                    <p class="font-medium">Nama :</p>
                    <p><?= $nama ?></p>
                    <p class="font-medium">Username :</p>
                    <p><?= $username ?></p>
                    <p class="font-medium">No. Telepon :</p>
                    <p><?= $telp ?> </p>
                </div>

                <div class="mt-10">
                    <?php
                    if (isset($_GET['error'])) {
                        if ($_GET['error'] == "kurang_karakter") {
                            echo "<h1 class='text-center text-red-500'>Password butuh minimal 8 karakter.</h1>";
                        } else if ($_GET['error'] == "data_kosong") {
                            echo "<h1 class='text-center text-red-500'>Data tidak boleh kosong.</h1>";
                        } else if ($_GET['error'] == "username_terpakai") {
                            echo "<h1 class='text-center text-red-500'>Username terpakai.</h1>";
                        } else if ($_GET['error'] == "konfirm_password") {
                            echo "<h1 class='text-center text-red-500'>Periksa kembali konfirmasi password.</h1>";
                        }
                    } else if (isset($_GET['perubahan_berhasil'])) {
                        echo "<h1 class='text-center text-green-500'>Perubahan Berhasil!</h1>";
                    }
                    ?>
                    <h1 class="hidden text-2xl font-medium text-center mb-2 sm:block">Ubah Username</h1>
                    <form method="post">
                        <label for="username" class="block font-medium mb-2">Ubah Username</label>
                        <input type="" name="username" class="w-full border rounded px-2 py-1 mb-2"
                            placeholder="Masukkan username baru">
                        <div class="mt-6 text-right">
                            <button type="submit" name="submit_nama"
                                class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 cursor-pointer">Submit
                                Perubahan</button>
                        </div>
                    </form>
                </div>
                <div class="mt-10">
                    <h1 class="hidden text-2xl font-medium text-center mb-2 sm:block">Ubah Nomor Telepon</h1>
                    <form method="post">
                        <label for="password" class="block font-medium mb-2">Ubah Nomor Telepon</label>
                        <input type="number" name="telepon" class="w-full border rounded px-2 py-1 mb-2 no-spinner"
                            placeholder="Masukkan nomor telepon baru">
                        <div class="mt-6 text-right">
                            <button type="submit" name="submit_telp"
                                class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 cursor-pointer">Submit
                                Perubahan</button>
                        </div>
                    </form>
                </div>
                <div class="mt-10">
                    <h1 class="hidden text-2xl font-medium text-center mb-2 sm:block">Ubah Password</h1>
                    <form method="post">
                        <label for="password" class="block font-medium mb-2">Ubah Password</label>
                        <input type="password" name="password" class="w-full border rounded px-2 py-1 mb-2"
                            placeholder="Masukkan password baru">
                        <label for="konfirm_password" class="block font-medium mb-2">Konfirmasi Password</label>
                        <input type="password" name="konfirm_password" class="w-full border rounded px-2 py-1 mb-2"
                            placeholder="Masukkan password yang baru anda masukan">
                        <div class="mt-6 text-right">
                            <button type="submit" name="submit_pass"
                                class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 cursor-pointer">Submit
                                Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <main>
            <h1 class="text-2xl md:text-3xl font-medium text-center mb-8">History Pengaduan</h1>

            <?php if ($total_data > $limit): ?>
                <div class="flex justify-center items-center space-x-1 my-6">
                    <a href="?page=<?= max(1, $page - 1) ?>" class="px-2 py-1 border rounded hover:bg-gray-200">
                        &lt;
                    </a>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?= $i ?>"
                            class="px-3 py-1 rounded <?= $i == $page ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-800' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                    <a href="?page=<?= min($total_pages, $page + 1) ?>" class="px-2 py-1 border rounded hover:bg-gray-200">
                        &gt;
                    </a>
                </div>
            <?php endif;

            if ($total_data == 0) {
                echo "<h1 class='text-center mb-10'>Belum ada data.</h1>";
            }
            ?>

            <?php foreach ($cariTanggapan as $data): ?>
                <div class="border border-gray-300 bg-white py-5 px-3 rounded-md mb-2 md:mx-21">
                    <h1 class="font-medium">ID Pengaduan: <?= $data['id_pengaduan']; ?></h1>
                    <p class="my-3 line-clamp-4"><?= $data['isi_laporan']; ?></p>

                    <?php
                    $statusCase = $data['status'];

                    switch ($statusCase) {
                        case 0:
                            $status = "Belum Terverifikasi";
                            $warna = "yellow";
                            break;
                        case "proses":
                            $status = "Proses";
                            $warna = "Blue";
                            break;
                        case "selesai":
                            $status = "Selesai";
                            $warna = "Green";
                            break;
                    }
                    ?>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center text-<?= $warna ?>-600">
                            <span class="w-3 h-3 bg-<?= $warna ?>-400 rounded-full mr-2"></span>
                            <?= $status ?>
                        </div>
                        <a href="detail-laporan.php?id=<?= $data['id_pengaduan']; ?>"
                            class="flex justify-end text-blue-500">Lihat
                            Detail ›</a>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if ($total_data > $limit): ?>
                <div class="flex justify-center items-center space-x-1 my-6">
                    <a href="?page=<?= max(1, $page - 1) ?>" class="px-2 py-1 border rounded hover:bg-gray-200">
                        &lt;
                    </a>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?= $i ?>"
                            class="px-3 py-1 rounded <?= $i == $page ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-800' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                    <a href="?page=<?= min($total_pages, $page + 1) ?>" class="px-2 py-1 border rounded hover:bg-gray-200">
                        &gt;
                    </a>
                </div>
            <?php endif; ?>

        </main>
    </main>
    <?php
    include './footer.php';
    ?>

</body>

</html>