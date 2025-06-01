<?php
include '../connect.php';
include './navbar_admin.php';


$limit = 12;

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page - 1) * $limit;

if (isset($_GET['kategori'])) {
    $kategori = $_GET['kategori'];

    if ($kategori == "belum-terverifikasi") {
        $total_data_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pengaduan WHERE status='0'");
        $data = mysqli_query($conn, "SELECT * FROM pengaduan WHERE status='0' ORDER BY id_pengaduan DESC LIMIT $start, $limit");
    } else if ($kategori == "proses") {
        $total_data_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pengaduan WHERE status='proses'");
        $data = mysqli_query($conn, "SELECT * FROM pengaduan WHERE status='proses' ORDER BY id_pengaduan DESC LIMIT $start, $limit");
    } else if ($kategori == "selesai") {
        $total_data_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pengaduan WHERE status='selesai'");
        $data = mysqli_query($conn, "SELECT * FROM pengaduan WHERE status='selesai' ORDER BY id_pengaduan DESC LIMIT $start, $limit");
    }

    $total_data = mysqli_fetch_assoc($total_data_result)['total'];
    $jumlahData = mysqli_num_rows($data);
    $total_pages = ceil($total_data / $limit);

} else {
    $total_data_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pengaduan");
    $data = mysqli_query($conn, "SELECT * FROM pengaduan ORDER BY id_pengaduan DESC LIMIT $start, $limit");
    $total_data = mysqli_fetch_assoc($total_data_result)['total'];
    $jumlahData = mysqli_num_rows($data);
    $total_pages = ceil($total_data / $limit);
}
;



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <title>Laporan</title>
</head>

<body class="flex flex-col min-h-screen">
    <main class="flex-grow">


        <h1 class="text-3xl text-center font-medium mt-5">Laporan</h1>
        <div class="flex justify-center gap-3 my-5">
            <a href="laporan.php"
                class="border-2 border-red-500 px-3 py-1 rounded-md text-red-500 font-medium">Semua</a>
            <a class="border-2 px-3 py-1 rounded-md border-yellow-500 text-yellow-500 font-medium"
                href="?kategori=belum-terverifikasi">Belum
                Terverifikasi</a>
            <a href="?kategori=proses"
                class="border-2 border-blue-500 px-3 py-1 rounded-md text-blue-500 font-medium">Proses</a>
            <a href="?kategori=selesai"
                class="border-2 border-green-500 px-3 py-1 rounded-md text-green-500 font-medium">Selesai</a>
        </div>

        <div class="flex justify-center items-center space-x-1 my-6">
            <?php if ($total_data > 0 && $total_pages > 1): ?>
                <a href="?<?= isset($kategori) ? "kategori=$kategori&" : "" ?>page=<?= max(1, $page - 1) ?>"
                    class="px-3 py-1 border rounded hover:bg-gray-200 <?= $page == 1 ? '/50 cursor-not-allowed' : '' ?>">
                    &lt;
                </a>

                <?php
                $range = 2;
                $start = max(1, $page - $range);
                $end = min($total_pages, $page + $range);

                if ($start > 1) {
                    echo '<a href="?' . (isset($kategori) ? "kategori=$kategori&" : "") . 'page=1" class="px-3 py-1 rounded bg-gray-200 text-gray-800 hover:bg-gray-300">1</a>';
                    if ($start > 2)
                        echo '<span class="px-2 text-gray-500">...</span>';
                }

                for ($i = $start; $i <= $end; $i++):
                    ?>
                    <a href="?<?= isset($kategori) ? "kategori=$kategori&" : "" ?>page=<?= $i ?>"
                        class="px-3 py-1 rounded <?= $i == $page ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor;

                if ($end < $total_pages) {
                    if ($end < $total_pages - 1)
                        echo '<span class="px-2 text-gray-500">...</span>';
                    echo '<a href="?' . (isset($kategori) ? "kategori=$kategori&" : "") . 'page=' . $total_pages . '" class="px-3 py-1 rounded bg-gray-200 text-gray-800 hover:bg-gray-300">' . $total_pages . '</a>';
                }
                ?>

                <a href="?<?= isset($kategori) ? "kategori=$kategori&" : "" ?>page=<?= min($total_pages, $page + 1) ?>"
                    class="px-3 py-1 border rounded hover:bg-gray-200 <?= $page == $total_pages ? '/50 cursor-not-allowed' : '' ?>">
                    &gt;
                </a>
            <?php elseif ($total_data < 1): ?>
                <h1 class="text-gray-500">Belum ada laporan yang bisa diperiksa.</h1>
            <?php endif; ?>
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
                        <a href="laporan-detail.php?id=<?= $item['id_pengaduan'] ?>" class="text-blue-500">Lihat Detail
                            ›</a>
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
            <?php if ($total_data > 0 && $total_pages > 1): ?>
                <a href="?<?= isset($kategori) ? "kategori=$kategori&" : "" ?>page=<?= max(1, $page - 1) ?>"
                    class="px-3 py-1 border rounded hover:bg-gray-200 <?= $page == 1 ? '/50 cursor-not-allowed' : '' ?>">
                    &lt;
                </a>

                <?php
                $range = 2;
                $start = max(1, $page - $range);
                $end = min($total_pages, $page + $range);

                if ($start > 1) {
                    echo '<a href="?' . (isset($kategori) ? "kategori=$kategori&" : "") . 'page=1" class="px-3 py-1 rounded bg-gray-200 text-gray-800 hover:bg-gray-300">1</a>';
                    if ($start > 2)
                        echo '<span class="px-2 text-gray-500">...</span>';
                }

                for ($i = $start; $i <= $end; $i++):
                    ?>
                    <a href="?<?= isset($kategori) ? "kategori=$kategori&" : "" ?>page=<?= $i ?>"
                        class="px-3 py-1 rounded <?= $i == $page ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor;

                if ($end < $total_pages) {
                    if ($end < $total_pages - 1)
                        echo '<span class="px-2 text-gray-500">...</span>';
                    echo '<a href="?' . (isset($kategori) ? "kategori=$kategori&" : "") . 'page=' . $total_pages . '" class="px-3 py-1 rounded bg-gray-200 text-gray-800 hover:bg-gray-300">' . $total_pages . '</a>';
                }
                ?>

                <a href="?<?= isset($kategori) ? "kategori=$kategori&" : "" ?>page=<?= min($total_pages, $page + 1) ?>"
                    class="px-3 py-1 border rounded hover:bg-gray-200 <?= $page == $total_pages ? '/50 cursor-not-allowed' : '' ?>">
                    &gt;
                </a>
            <?php endif; ?>
        </div>
    </main>

    <?php
    include './footer.php';
    ?>
</body>

</html>