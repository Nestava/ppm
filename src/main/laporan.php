<?php
include '../connect.php';

$limit = 12;

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$total_data_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pengaduan");
$total_data = mysqli_fetch_assoc($total_data_result)['total'];
$total_pages = ceil($total_data / $limit);

$data = mysqli_query($conn, "SELECT * FROM pengaduan ORDER BY id_pengaduan DESC LIMIT $start, $limit");

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

    <h1 class="text-3xl text-center font-medium mt-5">Laporan</h1>
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

        <?php foreach ($data as $item): ?>
            <div class="border border-gray-400 p-4 rounded-lg shadow-sm h-[150px] flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-center">
                        <?php
                        $nama_result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik='" . $item['nik'] . "'"));
                        $nama = $nama_result['nama'];
                        ?>
                        <h2 class="font-medium"><?= $nama ?></h2>
                        <span class="text-md text-gray-500"><?= $item['tgl_pengaduan'] ?></span>
                    </div>
                    <p class="text-md text-gray-700 mt-2 line-clamp-2">
                        <?= $item['isi_laporan'] ?>
                    </p>
                </div>
                <div class="flex justify-between items-center mt-2 text-md font-medium">
                    <a href="laporan-detail.php?id=<?= $item['id_pengaduan'] ?>" class="text-blue-500">Lihat Detail ›</a>
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