<?php

include '../connect.php';
include './navbar.php';

$nik = $_SESSION['nik']['nik'];

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

$nik = $data['nik'];
$nama = $data['nama'];
$username = $data['username'];
$telp = $data['telp'];
$password = $data['password'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_nama'])) {
        $newUsername = $_POST['username'];
        mysqli_query($conn, "UPDATE masyarakat SET username='$newUsername' WHERE nik='$nik'");
        header("location:profil-masyarakat.php");
        exit;
    }
    if (isset($_POST['submit_telp'])) {
        $newTelepon = $_POST['telepon'];
        mysqli_query($conn, "UPDATE masyarakat SET telp='$newTelepon' WHERE nik='$nik'");
        header("location:profil-masyarakat.php");
        exit;
    }
    if (isset($_POST['submit_pass'])) {
        $newPassword = md5($_POST['password']);
        $conPassword = md5($_POST['konfirm_password']);
        if ($newPassword == $conPassword) {
            mysqli_query($conn, "UPDATE masyarakat SET password='$newPassword' WHERE nik='$nik'");
            header("location:profil-masyarakat.php");
            exit;
        } else if ($newPassword != $conPassword) {
            header("location:profil-masyarakat.php?pesan=gagal");
            exit;
        }
    }
}

$cariTanggapan = mysqli_query($conn, "SELECT * FROM pengaduan WHERE nik='$nik' ORDER BY id_pengaduan DESC LIMIT $start, $limit; ");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> -->
    <script src="https://cdn.tailwindcss.com"></script>

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

<body>
    <main class="max-w-3xl mx-auto mt-5 p-6 bg-white shadow-md rounded-lg mb-10 border border-slate-300">
        <h1 class="text-3xl font-medium text-center mb-8">Profil</h1>
        <div class="bg-gray-50 p-6 rounded-md border border-slate-300">

            <div class="grid grid-cols-2 gap-y-2 text-md text-gray-700">
                <p class="font-medium">ID</p>
                <p>: <?= $nik ?> </p>
                <p class="font-medium">Nama</p>
                <p>: <?= $nama ?></p>
                <p class="font-medium">Username</p>
                <p>: <?= $username ?></p>
                <p class="font-medium">No. Telepon</p>
                <p>: <?= $telp ?> </p>
            </div>

            <div class="mt-10">
                <h1 class="text-2xl font-medium text-center mb-2">Ubah Username</h1>
                <form method="post">
                    <label for="username" class="block font-medium mb-2">Ubah Username</label>
                    <input type="" name="username" class="w-full border rounded px-2 py-1 mb-2"
                        placeholder="Masukkan username baru">
                    <div class="mt-6 text-right">
                        <button type="submit" name="submit_nama"
                            class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Submit
                            Perubahan</button>
                    </div>
                </form>
            </div>
            <div class="mt-10">
                <h1 class="text-2xl font-medium text-center mb-2">Ubah Nomor Telepon</h1>
                <form method="post">
                    <label for="password" class="block font-medium mb-2">Ubah Nomor Telepon</label>
                    <input type="number" name="telepon" class="w-full border rounded px-2 py-1 mb-2 no-spinner"
                        placeholder="Masukkan nomor telepon baru">
                    <div class="mt-6 text-right">
                        <button type="submit" name="submit_telp"
                            class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Submit
                            Perubahan</button>
                    </div>
                </form>
            </div>
            <div class="mt-10">
                <h1 class="text-2xl font-medium text-center mb-2">Ubah Password</h1>
                <form method="post">
                    <label for="password" class="block font-medium mb-2">Ubah Password</label>
                    <input type="password" name="password" class="w-full border rounded px-2 py-1 mb-2"
                        placeholder="Masukkan password baru">
                    <label for="konfirm_password" class="block font-medium mb-2">Konfirmasi Password</label>
                    <input type="password" name="konfirm_password" class="w-full border rounded px-2 py-1 mb-2"
                        placeholder="Masukkan password yang baru anda masukan">
                    <div class="mt-6 text-right">
                        <button type="submit" name="submit_pass"
                            class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Submit
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <main>
        <h1 class="text-3xl font-medium text-center mb-8">History Aduan</h1>

        <div class="flex justify-center items-center space-x-1 my-6">
            <a href="?page=<?= max(1, $page - 1) ?>"
                class="px-2 py-1 border rounded hover:bg-gray-200">
                &lt;
            </a>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>"
                    class="px-3 py-1 rounded <?= $i == $page ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-800' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
            <a href="?page=<?= min($total_pages, $page + 1) ?>"
                class="px-2 py-1 border rounded hover:bg-gray-200">
                &gt;
            </a>
        </div>

        <?php foreach ($cariTanggapan as $data): ?>
            <div class="border border-gray-300 bg-white py-5 px-3 rounded-md mb-2 mx-21">
                <h1 class="font-medium">ID Pengaduan: <?= $data['id_pengaduan']; ?></h1>
                <p class="my-3 line-clamp-4"><?= $data['isi_laporan']; ?></p>
                <a href="detail-laporan.php?id=<?= $data['id_pengaduan']; ?>" class="flex justify-end text-blue-500">Lihat
                    Detail ›</a>
            </div>
        <?php endforeach; ?>

        <div class="flex justify-center items-center space-x-1 my-6">
            <a href="?page=<?= max(1, $page - 1) ?>"
                class="px-2 py-1 border rounded hover:bg-gray-200">
                &lt;
            </a>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>"
                    class="px-3 py-1 rounded <?= $i == $page ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-800' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
            <a href="?page=<?= min($total_pages, $page + 1) ?>"
                class="px-2 py-1 border rounded hover:bg-gray-200">
                &gt;
            </a>
        </div>

    </main>

</body>

</html>