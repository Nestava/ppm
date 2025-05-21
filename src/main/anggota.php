<?php
include '../connect.php';

if ($_SESSION['status'] != "login") {
    header("location:login-fe.php?pesan=belum_login");

    date_default_timezone_set("Asia/Jakarta");
}

$limit = 12;

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$total_data_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pengaduan");
$total_data = mysqli_fetch_assoc($total_data_result)['total'];
$total_pages = ceil($total_data / $limit);

$anggota = mysqli_query($conn, "SELECT * FROM petugas ORDER BY id_petugas DESC LIMIT $start, $limit");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Laporan</title>
</head>

<body>
    <?php
    include './navbar_admin.php';
    ?>

    <h1 class="text-3xl text-center font-medium mt-5">Anggota</h1>
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

    <div class="grid grid-cols-3 gap-3 m-5">

        <?php foreach ($anggota as $arr_anggota): ?>
            <div class="border border-gray-400 p-4 rounded-lg shadow-sm h-[100px] flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-center">
                        <h2 class="font-medium text-xl"><?= $arr_anggota['nama_petugas'] ?></h2>
                    </div>
                </div>
                <div class="flex justify-between items-center mt-2 text-md font-medium">
                    <a href="#" class="text-blue-500">Lihat Detail ›</a>
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
</body>

</html>