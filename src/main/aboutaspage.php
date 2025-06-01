<?php include './navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile</title>
</head>

<body class="flex flex-col min-h-screen">
  <main class="flex-grow">
    <h2 class="text-2xl font-semibold text-center text-red-900 mb-10 mt-10">About Us</h2>

    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <!-- Card 1 -->
      <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <h2 class="text-lg font-semibold">Nabhan Alzam</h2>
        <p class="text-sm text-gray-500 font-normal">Sebagai PM</p>
        <p class="text-gray-600 mt-2 text-sm font-normal">Bekerja sebagai perencanaan, mengkoordinasi dengan tim.</p>
        <div class="flex justify-center gap-3 mt-4">
        </div>
      </div>

      <!-- Card 2 -->
      <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <h2 class="text-lg font-semibold">Erlangga Alfahrizki</h2>
        <p class="text-sm text-gray-500 font-normal">Sebagai Anggota</p>
        <p class="text-gray-600 mt-2 text-sm font-normal">melaksanakan tugas sesuai arahan, memberi masukkan ide,
          Bekerja sama dengan tim pengembang untuk memastikan sistem yang dibuat sesuai kebutuhan pengguna.</p>
        <div class="flex justify-center gap-3 mt-4">
        </div>
      </div>

      <!-- Card 3 -->
      <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <h2 class="text-lg font-semibold">Rizky Raditya</h2>
        <p class="text-sm text-gray-500 font-normal">Sebagai Anggota</p>
        <p class="text-gray-600 mt-2 text-sm font-normal">melaksanakan tugas sesuai arahan, memberi masukkan ide,
          Bekerja sama dengan tim pengembang untuk memastikan sistem yang dibuat sesuai kebutuhan pengguna.</p>
        <div class="flex justify-center gap-3 mt-4">
        </div>
      </div>

      <!-- Card 4 -->
      <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <h2 class="text-lg font-semibold">Raisya Radysti</h2>
        <p class="text-gray-600 mt-2 text-sm font-normal">Sebagai Anggota</p>
        <p class="text-gray-600 mt-2 text-sm font-normal">melaksanakan tugas sesuai arahan, memberi masukkan ide,
          menyusun laporan dan bekerja sama dengan tim untuk perbaikan </p>
        <div class="flex justify-center gap-3 mt-4">
        </div>
      </div>

    </div>

  </main>
  <?php
  include './footer.php';
  ?>

</body>

</html>