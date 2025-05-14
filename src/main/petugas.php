<?php
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
    </div>
</body>

</html>