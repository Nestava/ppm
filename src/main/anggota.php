<?php
include '../connect.php';
include './navbar_admin.php';

$limit = 12;

$id = $_SESSION['id']['id_petugas'];

$cekAkun = mysqli_query($conn, "SELECT * FROM petugas WHERE id_petugas='$id'");
$akunMentah = mysqli_fetch_assoc($cekAkun);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page - 1) * $limit;

if (isset($_GET['level'])) {
    $level = $_GET['level'];

    if ($level == "admin") {
        $total_data_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM petugas WHERE level='admin'");
        $anggota = mysqli_query($conn, "SELECT * FROM petugas WHERE level='admin' LIMIT $start, $limit");
    } else if ($level == "petugas") {
        $total_data_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM petugas WHERE level='petugas'");
        $anggota = mysqli_query($conn, "SELECT * FROM petugas WHERE level='petugas' LIMIT $start, $limit");

    }

    $total_data = mysqli_fetch_assoc($total_data_result)['total'];
    $total_pages = ceil($total_data / $limit);

} else if (!isset($_GET['level'])) {
    $total_data_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM petugas");
    $anggota = mysqli_query($conn, "SELECT * FROM petugas LIMIT $start, $limit");
    $total_data = mysqli_fetch_assoc($total_data_result)['total'];
    $total_pages = ceil($total_data / $limit);
}
;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <title>Laporan</title>
</head>

<body class="flex flex-col min-h-screen">
    <main class="flex-grow">

        <h1 class="text-3xl text-center font-medium mt-5">Anggota</h1>
        <div class="flex justify-center gap-3 my-5">
            <a href="anggota.php"
                class="border-2 px-3 py-1 rounded-md text-red-500 border-red-500 font-medium">Semua</a>
            <a href="?level=admin"
                class="border-2 px-3 py-1 rounded-md text-blue-500 border-blue-500 font-medium">Admin</a>
            <a href="?level=petugas"
                class="border-2 px-3 py-1 rounded-md text-green-500 border-green-500 font-medium">Petugas</a>
        </div>

        <?php if ($akunMentah['level'] == 'admin'): ?>
            <a href="register-admin.php" class="cursor-pointer">
                <div class="flex justify-end mx-9">
                    <button class="border-2 rounded-2xl px-3 py-1 font-medium cursor-pointer border-black">+ Register
                        Petugas</button>
                </div>
            </a>
        <?php endif; ?>

        <div class="flex justify-center items-center space-x-1 my-6">
            <?php if ($total_data > 0 && $total_pages > 1): ?>
                <a href="?<?= isset($level) ? "level=$level&" : "" ?>page=<?= max(1, $page - 1) ?>"
                    class="px-3 py-1 border rounded hover:bg-gray-200 <?= $page == 1 ? '/50 cursor-not-allowed' : '' ?>">
                    &lt;
                </a>

                <?php
                $range = 2;
                $start = max(1, $page - $range);
                $end = min($total_pages, $page + $range);

                if ($start > 1) {
                    echo '<a href="?' . (isset($level) ? "level=$level&" : "") . 'page=1" class="px-3 py-1 rounded bg-gray-200 text-gray-800 hover:bg-gray-300">1</a>';
                    if ($start > 2)
                        echo '<span class="px-2 text-gray-500">...</span>';
                }

                for ($i = $start; $i <= $end; $i++):
                    ?>
                    <a href="?<?= isset($level) ? "level=$level&" : "" ?>page=<?= $i ?>"
                        class="px-3 py-1 rounded <?= $i == $page ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor;

                if ($end < $total_pages) {
                    if ($end < $total_pages - 1)
                        echo '<span class="px-2 text-gray-500">...</span>';
                    echo '<a href="?' . (isset($level) ? "level=$level&" : "") . 'page=' . $total_pages . '" class="px-3 py-1 rounded bg-gray-200 text-gray-800 hover:bg-gray-300">' . $total_pages . '</a>';
                }
                ?>

                <a href="?<?= isset($level) ? "level=$level&" : "" ?>page=<?= min($total_pages, $page + 1) ?>"
                    class="px-3 py-1 border rounded hover:bg-gray-200 <?= $page == $total_pages ? '/50 cursor-not-allowed' : '' ?>">
                    &gt;
                </a>
            <?php elseif ($total_data < 1): ?>
                <h1 class="text-gray-500">Belum ada anggota yang bisa diperiksa.</h1>
            <?php endif; ?>
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
                        <a href="anggota-detail.php?id=<?= $arr_anggota['id_petugas'] ?>" class="text-blue-500">Lihat Detail
                            ›</a>
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
            <?php if ($total_data > 0 && $total_pages > 1): ?>
                <a href="?<?= isset($level) ? "level=$level&" : "" ?>page=<?= max(1, $page - 1) ?>"
                    class="px-3 py-1 border rounded hover:bg-gray-200 <?= $page == 1 ? '/50 cursor-not-allowed' : '' ?>">
                    &lt;
                </a>

                <?php
                $range = 2;
                $start = max(1, $page - $range);
                $end = min($total_pages, $page + $range);

                if ($start > 1) {
                    echo '<a href="?' . (isset($level) ? "level=$level&" : "") . 'page=1" class="px-3 py-1 rounded bg-gray-200 text-gray-800 hover:bg-gray-300">1</a>';
                    if ($start > 2)
                        echo '<span class="px-2 text-gray-500">...</span>';
                }

                for ($i = $start; $i <= $end; $i++):
                    ?>
                    <a href="?<?= isset($level) ? "level=$level&" : "" ?>page=<?= $i ?>"
                        class="px-3 py-1 rounded <?= $i == $page ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor;

                if ($end < $total_pages) {
                    if ($end < $total_pages - 1)
                        echo '<span class="px-2 text-gray-500">...</span>';
                    echo '<a href="?' . (isset($level) ? "level=$level&" : "") . 'page=' . $total_pages . '" class="px-3 py-1 rounded bg-gray-200 text-gray-800 hover:bg-gray-300">' . $total_pages . '</a>';
                }
                ?>

                <a href="?<?= isset($level) ? "level=$level&" : "" ?>page=<?= min($total_pages, $page + 1) ?>"
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