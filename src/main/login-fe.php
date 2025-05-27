<?php
include '../connect.php';
include '../backend/login-be.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="../output.css" rel="stylesheet" />
  <title>Login</title>
  <!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> -->
</head>

<body class="bg-linear-to-r from-[#FF4545] to-[#600000] h-screen flex items-center justify-center">
  <div class="bg-white justify-items-center px-4 pt-9 pb-12 rounded-xl">
    <div class="justify-items-center mb-6 border-b-2 border-b-[#870000]">
      <h1 class="text-2xl font-bold mb-1 text-[#870000]">Login</h1>
      <p class="text-sm">Selamat datang kembali. Silahkan masukkan Kredensial Login</p>
      <p class="text-sm mb-3">untuk kembali mengakses layanan ini.</p>
    </div>

    <?php
    if (isset($_GET['pesan'])) {
      if ($_GET['pesan'] == "gagal") {
        echo "<h1>Login Gagal! Password atau Username salah.</h1>";
      } else if ($_GET['pesan'] == "logout") {
        echo "<h1>Logout berhasil.</h1>";
      } else if ($_GET['pesan'] == "belum_login") {
        echo "<h1>Mohon login terlebih dahulu.</h1>";
      }
    }
    ?>

    <form name="login" method="post" class="mb-3">
      <div class="mb-8">
        <div class="mb-3">
          <label for="username">Username</label><br />
          <input id="username" name="username"
            class="mt-2 w-sm bg-gray-100 border-1 border-slate-300 rounded-lg px-1.5 py-1"
            placeholder="Masukkan Username" />
        </div>
        <div>
          <label for="password">Password</label><br />
          <input id="password" name="password" type="password"
            class="mt-2 w-sm bg-gray-100 border-1 border-slate-300 rounded-lg px-1.5 py-1"
            placeholder="Masukkan Password" />
        </div>
      </div>
      <button type="submit" value="Login"
        class="w-sm text-sm py-1.5 rounded-lg bg-red-700 text-white cursor-pointer">LOGIN</button>
    </form>
    <a>Belum memiliki akun?
      <a class="text-blue-400 hover:underline focus:text-blue-600" href="register-fe.php">
        Register di sini!
      </a>
    </a>
  </div>
  </div>
</body>

</html>