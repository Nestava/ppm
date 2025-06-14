<?php

include '../backend/auth.php';

if (!isset($_SESSION['id'])) {
    header("location:masyarakat.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../output.css" rel="stylesheet" />
</head>

<body>
    <nav class="bg-[#BA0000] px-20 py-4 flex items-center">
        <a class="text-white text-4xl font-bold cursor-pointer" href="./petugas.php">PPM</a>
        <div class="ml-auto">
            <a class="text-white mr-10 font-medium" href="./profil-admin.php">Profil</a>
            <a class="text-white mr-10 font-medium" href="./petugas.php">Petugas</a>
            <a class="text-white mr-10 font-medium" href="./laporan.php">Laporan</a>
            <a class="text-white mr-10 font-medium" href="./anggota.php">Anggota</a>
            <a class="text-white bg-[#570000] px-4 py-2 rounded-3xl font-medium" href="../backend/logout.php">Logout</a>
        </div>
    </nav>
</body>

</html>