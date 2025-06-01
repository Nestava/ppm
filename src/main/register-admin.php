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
    $con_password = md5($_POST['con-password']);
    $level = isset($_POST['level']) ? $_POST['level'] : '';

    $validasi = mysqli_query($conn, "SELECT * FROM petugas WHERE username='$username'");
    $validasi2 = mysqli_query($conn, "SELECT * FROM masyarakat WHERE username='$username'");

    if (empty($nama) || empty($username) || empty($telp) || empty($_POST['password']) || empty($_POST['con-password']) || empty($level)) {
        header("location:register-admin.php?error=data_kosong");
        exit;
    }

    if (mysqli_num_rows($validasi) > 0 || mysqli_num_rows($validasi2) > 0) {
        header("location:register-admin.php?error=username_terpakai");
        exit;
    }

    if ($password != $con_password) {
        header("location:register-admin.php?error=konfirmasi_password");
        exit;
    } else if (strlen($_POST['password']) < 8) {
        header("location:register-admin.php?error=kurang_karakter");
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
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <style>
        input.no-spinner::-webkit-inner-spin-button,
        input.no-spinner::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input.no-spinner {
            -moz-appearance: textfield;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen">

    <main class="flex-grow">

        <div class="max-w-xl mx-auto mt-10 p-6 bg-white shadow-md rounded-md border">
            <h2 class="text-2xl font-medium text-center">Register Admin</h2>

            <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == "username_terpakai") {
                    echo "<h1 class='text-center text-red-500'>Username sudah terpakai.</h1>";
                } else if ($_GET['error'] == "konfirmasi_password") {
                    echo "<h1 class='text-center text-red-500'>Cek kembali konfirmasi password.</h1>";
                } else if ($_GET['error'] == "data_kosong") {
                    echo "<h1 class='text-center text-red-500'>Data tidak boleh kosong.</h1>";
                } else if ($_GET['error'] == "kurang_karakter") {
                    echo "<h1 class='text-center text-red-500'>Password harus memiliki minimal 8 karakter.</h1>";
                }
            }
            ?>

            <form method="post">
                <div class="mb-4 mt-6">
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
                    <input type="number" name="telp"
                        class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring focus:ring-blue-200 no-spinner" />
                </div>

                <div class="mb-4">
                    <label class="mb-1">Password</label>
                    <input type="password" name="password"
                        class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring focus:ring-blue-200" />
                </div>

                <div class="mb-4">
                    <label class="mb-1">Confirm Password</label>
                    <input type="password" name="con-password"
                        class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring focus:ring-blue-200" />
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Level</label>
                    <div class="flex gap-2">
                        <input type="radio" id="petugas" name="level" value="petugas" class="peer/petugas hidden">
                        <label for="petugas"
                            class="peer-checked/petugas:outline-2 peer-checked/petugas:outline-offset-1 peer-checked/petugas:outline-green-500 flex justify-center items-center gap-2 border px-3 py-1 rounded-md text-white bg-green-500 font-medium w-1/2 cursor-pointer">
                            Petugas
                        </label>

                        <input type="radio" id="admin" name="level" value="admin" class="peer/admin hidden">
                        <label for="admin"
                            class="peer-checked/admin:outline-2 peer-checked/admin:outline-offset-1 peer-checked/admin:outline-blue-500 flex justify-center items-center gap-2 border px-3 py-1 rounded-md text-white bg-blue-500 font-medium w-1/2 cursor-pointer">
                            Admin
                        </label>
                    </div>
                </div>


                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white w-full py-2 rounded font-semibold cursor-pointer">Submit</button>
            </form>
        </div>
    </main>

    <?php
    include './footer.php';
    ?>

</body>

</html>