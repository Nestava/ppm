<?php
include '../connect.php';
include './navbar_admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $query = mysqli_query($conn, "SELECT MAX(id_petugas) AS max_id FROM petugas");
    $row = mysqli_fetch_assoc($query);
    $id = $row['max_id'] ? $row['max_id'] + 1 : 1000;

    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $telp = $_POST['telp'];
    $password = md5($_POST['password']);
    $level = isset($_POST['level']) ? $_POST['level'] : '';

    $validasi = mysqli_query($conn, "SELECT * FROM petugas WHERE username='$username'");
    $validasi2 = mysqli_query($conn, "SELECT * FROM masyarakat WHERE username='$username'");

    if (mysqli_num_rows($validasi) > 0 || mysqli_num_rows($validasi2) > 0) {
        header("location:register-admin.php?username=terpakai");
        exit;
    }

    if ($level == 'admin' || $level == 'petugas') {
        mysqli_query($conn, "INSERT INTO petugas(id_petugas, nama_petugas, username, password, telp, level) VALUES('$id', '$nama', '$username', '$password', '$telp', '$level')");
    }

    header("location:anggota.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-white">

    <div class="max-w-xl mx-auto mt-10 p-6 bg-white shadow-md rounded-md border">
        <h2 class="text-2xl font-medium text-center mb-6">Register Admin</h2>

        <?php
        if (isset($_GET['username'])) {
        echo "<h1 class='text-center text-red-500'>Username sudah terpakai.</h1>";
        }
        ?>

        <form method="post">
            <div class="mb-4">
                <label class="mb-1">Nama Petugas</label>
                <input type="text" name="nama"
                    class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring focus:ring-blue-200" />
            </div>

            <div class="mb-4">
                <label class="mb-1">Username</label>
                <input type="text" name="username"
                    class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring focus:ring-blue-200" />
            </div>

            <div class="mb-4">
                <label class="mb-1">Telepon</label>
                <input type="text" name="telp"
                    class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring focus:ring-blue-200" />
            </div>

            <div class="mb-4">
                <label class="mb-1">Password</label>
                <input type="password" name="password"
                    class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring focus:ring-blue-200" />
            </div>

            <div class="mb-4">
                <label class="block mb-1">Level</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="level" value="petugas">
                        Petugas
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="level" value="admin">
                        Admin
                    </label>
                </div>
            </div>

            <button type="submit"
                class="bg-red-600 hover:bg-red-700 text-white w-full py-2 rounded font-semibold">Submit</button>
        </form>
    </div>

    <?php
    include './footer.php';
    ?>

</body>

</html>