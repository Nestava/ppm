<?php

include '../connect.php';
include './navbar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan</title>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

< class="m-8">
    <div class="flex items-center justify-center">
        <div class="border border-slate-300 rounded-xl shadow px-5 pt-5 pb-10">
            <h1 class="text-3xl font-medium text-center mb-5">
                Laporan
            </h1>
            <div class="flex gap-96 mb-5">
                <div>
                    <h2 class="font-medium">Tanggal Pelaporan</h2>
                    <h2 class="ml-3">27-5-2025</h2>
                </div>
                <div>
                    <h2 class="font-medium">ID Pengaduan</h2>
                    <h2 class="ml-3">1001</h2>
                </div>
            </div>
            <div class="mb-5">
                <h2 class="font-medium">Identitas Pelapor</h2>
                <div class="ml-3">
                    <h2>NIK: 328321083090</h2>
                    <h2>Nama: Erlangga</h2>
                    <h2>Username: 3rlangg4</h2>
                    <h2>No. Telepon: 08129029021</h2>
                </div>
            </div>
            <div class="mb-5">
                <h2 class="font-medium">Isi Pengaduan</h2>
                <p class="ml-3 w-153">Laporan jembatan cijeruk runtuh. pemerintah setempat mohon perbaiki segera, terima
                    kasih</p>
            </div>
            <div class="mb-5">
                <h2 class="font-medium">Foto</h2>
                <input type="image" ="./Cijeruk.jpg">
            </div>
            <div class="flex justify-between">

                <div class="flex items-center text-yellow-600">
                    <span class="w-3 h-3 bg-yellow-400 rounded-full mr-2"></span>
                    Belum terverifikasi
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