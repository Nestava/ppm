<?php
include '../connect.php';
include '../backend/register-be.php';

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../output.css" rel="stylesheet" />
    <!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> -->
    <title>Register</title>
</head>

<body class="bg-linear-to-r from-[#FF4545] to-[#600000] h-screen flex items-center justify-center">
    <div class="mx-4 my-4">
        <div class="bg-white justify-items-center px-4 py-4 rounded-xl">
            <div class="justify-items-center mb-3">
                <h1 class="text-2xl font-bold mb-1 text-[#870000]">Register</h1>
                <p class="text-sm">Selamat datang. Silahkan masukkan data anda</p>
                <p class="text-sm mb-3">untuk membuat akun agar bisa mengakses layanan ini.</p>
            </div>

            <div class="text-red-500">
                <?php
            if (isset($_GET['pesan'])) {
                if ($_GET['pesan'] == "gagal") {
                    echo "<h1 class='text-red-500'>Register Gagal!</h1>";
                } else if ($_GET['pesan'] == "password_error") {
                    echo "<h1 class='text-red-500'>Password dan Confirm Password tidak sama.</h1>";
                } else if ($_GET['pesan'] == "input_error") {
                    echo "<h1 class='text-red-500'>Mohon isi semua kolom.</h1>";
                } else if ($_GET['pesan'] == "register_berhasil") {
                    echo "<h1 class='text-red-500'>Register berhasil.</h1>";
                } else if ($_GET['pesan'] == "nik-terpakai") {
                    echo "<h1 class='text-red-500'>NIK sudah terpakai.</h1>";
                } else if ($_GET['pesan'] == "username-terpakai") {
                    echo "<h1 class='text-red-500'>Username sudah terpakai.</h1>";
                } else if ($_GET['pesan'] == "password_pendek") {
                    echo "<h1 class='text-red-500'>Password Minimal 8 karakter</h1>";
                }
                
            }
            ?>
            </div>

            <form name="register" method="post">
                <div class="mb-5 border-t-2 border-[#870000]">
                    <div class="mb-1 mt-5">
                        <label for="nik">NIK</label><br />
                        <input id="nik" name="nik"
                            class="w-sm bg-gray-100 border-1 border-slate-300 rounded-lg px-1.5 py-1"
                            placeholder="Masukkan NIK" />
                    </div>
                    <div class="mb-1">
                        <label for="name">Nama Lengkap</label><br />
                        <input id="name" name="name"
                            class="w-sm bg-gray-100 border-1 border-slate-300 rounded-lg px-1.5 py-1"
                            placeholder="Masukkan Nama" />
                    </div>
                    <div class="mb-1">
                        <label for="username">Username</label><br />
                        <input id="username" name="username"
                            class="w-sm bg-gray-100 border-1 border-slate-300 rounded-lg px-1.5 py-1"
                            placeholder="Masukkan Username" />
                    </div>
                    <div class="mb-1">
                        <label for="telepon">Telepon</label><br />
                        <input id="telepon" name="telepon"
                            class="w-sm bg-gray-100 border-1 border-slate-300 rounded-lg px-1.5 py-1"
                            placeholder="Masukkan No. Telepon" />
                    </div>
                    <div class="mb-1">
                        <label>Password</label><br />
                        <input id="password" name="password" type="password"
                            class="w-sm bg-gray-100 border-1 border-slate-300 rounded-lg px-1.5 py-1"
                            placeholder="Masukkan Password" />
                    </div>
                    <div class="mb-1">
                        <label>Confirm Password</label><br />
                        <input id="con-password" name="con-password" type="password"
                            class="w-sm bg-gray-100 border-1 border-slate-300 rounded-lg px-1.5 py-1   "
                            placeholder="Konfirmasi Password" />
                    </div>
                </div>
                <button type="submit" value="Register"
                    class="w-sm text-sm py-1.5 rounded-lg bg-red-700 text-white mb-4 cursor-pointer">REGISTER</button>
            </form>
            <a>
                Sudah memiliki akun?
                <a class="text-blue-400 hover:underline focus:text-blue-600 " href="login-fe.php">
                    Login di sini!
                </a>
            </a>
        </div>
    </div>
</body>

</html>