<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <title>Document</title>
</head>

<body class="">
    <footer
        class="w-full bottom-0 bg-red-700 text-white mt-28 py-6 justify-center items-center text-center text-sm flex gap-8 static">
        <?php if (isset($_SESSION['nik'])): ?>
            <a href="masyarakat.php">Lapor</a>
            <p class="font-bold text-xl">PPM</p>
            <a href="aboutaspage.php">About Us</a>
        <?php else: ?>
            <a href="petugas.php">Petugas</a>
            <a href="laporan.php">Laporan</a>
            <a href="anggota.php">Anggota</a>
        <?php endif; ?>
    </footer>
</body>

</html>