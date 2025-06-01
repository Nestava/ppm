<?php
include '../connect.php';
include './navbar_admin.php';

$id = $_SESSION['id']['id_petugas'];

$cariStatus = mysqli_query($conn, "SELECT * FROM petugas WHERE id_petugas='$id'");
$statusMentah = mysqli_fetch_assoc($cariStatus);

//

$limit = 12;

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$total_data_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tanggapan WHERE id_petugas='" . $_GET['id'] . "'");
$total_data = mysqli_fetch_assoc($total_data_result)['total'];
$total_pages = ceil($total_data / $limit);

//

$cariPetugas = mysqli_query($conn, "SELECT * FROM petugas WHERE id_petugas='" . $_GET['id'] . "'");
$petugasMentah = mysqli_fetch_assoc($cariPetugas);

if ($petugasMentah['level'] == 'admin') {
    $warna = "blue";
    $level = "Admin";
} else if ($petugasMentah['level'] == 'petugas') {
    $warna = "green";
    $level = "Petugas";
}
;
?>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') :?>
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white px-5 py-5 rounded-xl">
            <h1 class="">Apakah anda yakin ingin menghapus akun ini?</h1>
            <div class="flex justify-end gap-2 mt-5">
                <?php if (isset($_POST['hapus'])) : ?>
                    <form method="post">
                        <button class="border-2 border-red-600 text-red-600 font-medium py-1 px-5 rounded-md cursor-pointer" name="ya">Ya</button>
                        <button class="border-2 border-green-600 text-green-600 font-medium py-1 px-3 rounded-md cursor-pointer" name="tidak">Tidak</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php

if (isset($_POST['ya'])) {
    mysqli_query($conn, "DELETE FROM petugas WHERE id_petugas='" .  $_GET['id'] . "'");

    header("location:anggota.php");
    exit;
} else if (isset($_POST['tidak'])) {
    header("location: anggota-detail.php?id=" . $_GET['id']);
    exit;
}

$cariTanggapan = mysqli_query($conn, "SELECT * FROM tanggapan WHERE id_petugas='" . $petugasMentah['id_petugas'] . "' ORDER BY id_tanggapan DESC LIMIT $start, $limit; ");

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anggota PPM</title>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
</head>

<body>
    <main class="py-4 px-8 gap-5">
        <div class="w-2/3 mx-auto">
            <h2 class="text-3xl font-medium mb-5 text-center">Detail Anggota</h2>
            <div class="bg-gray-100 rounded-lg px-6 py-20 shadow-md h-2/3">
                <div class="flex">
                    <div>
                        <p class="mb-2">ID Petugas</p>
                        <p class="mb-2">Nama Petugas</p>
                        <p class="mb-2">Username</p>
                        <p class="mb-2">No. Telepon</p>
                        <p class="mb-2">Level</p>
                    </div>
                    <div class="ml-3">
                        <p class="mb-2">:</p>
                        <p class="mb-2">:</p>
                        <p class="mb-2">:</p>
                        <p class="mb-2">:</p>
                        <p class="mb-2">:</p>
                    </div>
                    <div class="ml-3">
                        <p class="mb-2"><?= $petugasMentah['id_petugas'] ?></p>
                        <p class="mb-2"><?= $petugasMentah['nama_petugas'] ?></p>
                        <p class="mb-2"><?= $petugasMentah['username'] ?></p>
                        <p class="mb-2"><?= $petugasMentah['telp'] ?></p>
                        <p class="mb-2 text-<?= $warna ?>-500"><?= $level ?></p>
                    </div>
                </div>
                <?php if ($statusMentah['level'] == 'admin'): ?>
                    <?php if ($level == "Petugas"): ?>
                        <form method="post">
                            <a href="../backend/hapus-anggota.php">
                                <div class="flex justify-end">
                                    <button class="mt-14 bg-red-600 text-white py-2 px-4 rounded cursor-pointer" name="hapus" type="submit">Hapus
                                        Akun</button>
                                </div>
                            </a>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="w-11/12 mx-auto">
            <h2 class="text-3xl font-medium mb-5 mt-10 text-center">History Tanggapan</h2>

            <?php if ($total_data > $limit): ?>
            <div class="flex justify-center items-center space-x-1 my-6">
                <a href="?id=<?= $_GET['id']; ?>&page=<?= max(1, $page - 1) ?>"
                    class="px-2 py-1 border rounded hover:bg-gray-200">
                    &lt;
                </a>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?id=<?= $_GET['id']; ?>&page=<?= $i ?>"
                        class="px-3 py-1 rounded <?= $i == $page ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-800' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
                <a href="?id=<?= $_GET['id']; ?>&page=<?= min($total_pages, $page + 1) ?>"
                    class="px-2 py-1 border rounded hover:bg-gray-200">
                    &gt;
                </a>
            </div>
            <?php endif; ?>
            <?php if ($total_data == 0) {
                echo "<h1 class='text-center mb-10'>Belum ada data.</h1>";
            }
            ?>

            <?php foreach ($cariTanggapan as $data): ?>
                <div class="border border-gray-300 bg-white py-5 px-3 rounded-md mb-2">
                    <h1 class="font-medium">ID Tanggapan: <?= $data['id_tanggapan']; ?></h1>
                    <h1 class="font-medium">ID Pengaduan: <?= $data['id_pengaduan']; ?></h1>
                    <p class="my-3 line-clamp-4"><?= $data['tanggapan']; ?></p>
                    <a href="laporan-detail.php?id=<?= $data['id_pengaduan']; ?>"
                        class="flex justify-end text-blue-500">Lihat Detail ›</a>
                </div>
            <?php endforeach; ?>

            <?php if ($total_data > $limit): ?>
            <div class="flex justify-center items-center space-x-1 my-6">
                <a href="?id=<?= $_GET['id']; ?>&page=<?= max(1, $page - 1) ?>"
                    class="px-2 py-1 border rounded hover:bg-gray-200">
                    &lt;
                </a>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?id=<?= $_GET['id']; ?>&page=<?= $i ?>"
                        class="px-3 py-1 rounded <?= $i == $page ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-800' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
                <a href="?id=<?= $_GET['id']; ?>&page=<?= min($total_pages, $page + 1) ?>"
                    class="px-2 py-1 border rounded hover:bg-gray-200">
                    &gt;
                </a>
            </div>
            <?php endif; ?>

        </div>
    </main>
</body>

</html>


<?php 
include './footer.php';
?>