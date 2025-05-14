<?php
include '../connect.php';
session_start()
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="../output.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="">
    <?php
    include '../navbar_admin.php';
    ?>
    <div class="mx-15 my-8">
        <div>
            <h1 class="text-3xl font-medium">Selamat Datang, <?php echo $_SESSION['username']; ?>, di Page Petugas</h1>
            <h2 class="text-2xl">Selamat Bekerja.</h2>
        </div>

        <div class="mt-15">
            <div>
                <h1 class="mb-6 text-3xl">
                    Laporan
                </h1>
                <div class="grid grid-cols-2 gap-5">
                    <?php
                    $data = mysqli_query($conn, "SELECT * FROM pengaduan");
                    ?>

                    <div class="border border-gray-300 rounded-lg shadow overflow-hidden">
                        <div class="h-[500px] overflow-y-scroll space-y-4 p-4">
                            <?php foreach ($data as $item): ?>
                                <div
                                    class="border border-gray-400 p-4 rounded-lg shadow-sm h-[150px] flex flex-col justify-between">
                                    <div>
                                        <div class="flex justify-between items-center">
                                            <h2 class="font-medium text-xl"><?= htmlspecialchars($item['nik']) ?></h2>
                                            <span
                                                class="text-md text-gray-500"><?= htmlspecialchars($item['tgl_pengaduan']) ?></span>
                                        </div>
                                        <p class="text-md text-gray-700 mt-2 line-clamp-2">
                                            <?= htmlspecialchars($item['isi_laporan']) ?>
                                        </p>
                                    </div>
                                    <div class="flex justify-between items-center mt-2 text-md font-medium">
                                        <a href="#" class="text-blue-500">Lihat Detail ›</a>
                                        <div class="flex items-center text-<?= $item['warna'] ?>-600">
                                            <span class="w-3 h-3 bg-<?= $item['warna'] ?>-400 rounded-full mr-2"></span>
                                            <?= htmlspecialchars($item['status']) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="border-t px-4 py-3 text-center bg-white">
                            <button
                                class="text-blue-500 font-semibold text-sm hover:underline flex items-center justify-center mx-auto">
                                Lihat Lebih Banyak
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="border rounded-lg shadow overflow-hidden">
                        <div class="h-[500px] overflow-y-scroll space-y-4 p-4">
                            <div class="border p-4 rounded-lg shadow-sm h-[150px] flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-center">
                                        <h2 class="font-bold">Nama</h2>
                                        <span class="text-sm text-gray-500">4/21/2025</span>
                                    </div>
                                    <p class="text-sm text-gray-700 mt-2 line-clamp-2">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit...
                                    </p>
                                </div>
                                <div class="flex justify-between items-center mt-2">
                                    <a href="#" class="text-blue-500 text-sm font-medium">Lihat Detail ›</a>
                                    <div class="flex items-center text-sm font-medium text-yellow-600">
                                        <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span> Belum
                                        Terverifikasi
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-t px-4 py-3 text-center bg-white">
                            <button
                                class="text-blue-500 font-semibold text-sm hover:underline flex items-center justify-center mx-auto">
                                Lihat Lebih Banyak
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                Anggota
            </div>
        </div>
    </div>
</body>

</html>