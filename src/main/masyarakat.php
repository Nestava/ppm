<?php
include '../connect.php';
include './navbar.php';

$nik = $_SESSION['nik'];

$cariMasyarakat = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik='" . $_SESSION['nik'] . "'");
$masyarakatMentah = mysqli_fetch_assoc($cariMasyarakat);

date_default_timezone_set("Asia/Jakarta");

if (isset($_POST['submit'])) {
    include '../backend/kirim_laporan.php';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="../output.css" rel="stylesheet" /> -->
    <title>Masyarakat</title>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
</head>

<body class="flex flex-col min-h-screen">

    <main class="flex-grow">

        <div class="my-16 md:mx-30">
            <div class="text-xl md:text-3xl font-medium text-center">
                <p>Selamat datang, <?= $masyarakatMentah['username'] ?>, di</p>
                <p>Layanan Pengaduan Pelaporan Masyarakat Online</p>
            </div>
            <p class="mx-4 text-md md:text-2xl font-light text-center mt-2">Sampaikan Pengaduan Anda Secara Cepat dan
                Tepat</p>

            <div class="w-full max-w-4xl mx-auto mt-7">
                <div class="bg-white shadow-md rounded-md overflow-hidden border border-gray-300">
                    <input type="checkbox" id="toggle-accordion" class="peer hidden">
                    <label for="toggle-accordion" class="flex justify-between items-center px-4 py-5 cursor-pointer">
                        <div class="text-xl md:text-2xl">
                            <span class="font-semibold">Peraturan</span>
                            <span class="font-light text-gray-500 ml-1">(Harap dibaca sebelum mengisi laporan)</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </label>
                    <div
                        class="max-h-0 overflow-hidden peer-checked:max-h-[1000px] transition-all duration-500 ease-in-out px-4">
                        <ol class="text-gray-800 space-y-4 py-4 text-sm md:text-md list-decimal list-inside">
                            <li class="border-t pt-4">
                                <strong>Gunakan bahasa yang sopan dan jelas</strong><br>
                                Setiap laporan atau aduan yang dikirimkan harus menggunakan bahasa yang santun, tidak
                                mengandung unsur SARA, kebencian, atau provokasi.
                            </li>
                            <li class="border-t pt-4">
                                <strong>Sampaikan Laporan dengan Data yang Valid</strong><br>
                                Pengguna wajib menyampaikan informasi yang benar dan dapat dipertanggungjawabkan.
                            </li>
                            <li class="border-t pt-4">
                                <strong>Tidak Menggunakan Sistem untuk Kepentingan Pribadi atau Komersial</strong><br>
                                Laporan harus berkaitan dengan kepentingan publik. Sistem ini tidak untuk promosi usaha,
                                kampanye, atau kepentingan pribadi lainnya.
                            </li>
                            <li class="border-t pt-4">
                                <strong>Dilarang Melakukan Spam atau Pengulangan Laporan Berlebihan</strong><br>
                                Pelaporan yang sama secara berulang-ulang tanpa pembaruan informasi dianggap sebagai
                                spam
                                dan tidak akan diverifikasi.
                            </li>
                            <li class="border-t pt-4">
                                <strong>Laporan Ditindaklanjuti Sesuai Prosedur</strong><br>
                                Setiap laporan akan diverifikasi terlebih dahulu sebelum ditindaklanjuti. Harap bersabar
                                dalam menunggu respons dari petugas.
                            </li>
                            <li class="border-t pt-4">
                                <strong>Sistem Diawasi dan Dicatat</strong><br>
                                Segala aktivitas di dalam sistem akan tercatat secara otomatis.
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <form class="w-full max-w-4xl mx-auto mt-10 mb-10" method="post" enctype="multipart/form-data">
                <div class="border border-gray-300 py-4 px-3 md:px-7 rounded-md gap-2">
                    <h1 class="text-xl md:text-3xl text-center font-medium">
                        Laporan Pengaduan
                    </h1>
                    <div class="mt-2 mb-5">
                        <label for="laporan">Isi Pengaduan</label><br>
                        <?php
                        if (isset($_GET['pesan'])) {
                            if ($_GET['pesan'] == "laporan_tidak_valid") {
                                echo "<h1 class='text-center text-red-500'>Laporan terlalu pendek</h1>";
                            } else
                                if ($_GET['pesan'] == "laporan_kosong") {
                                    echo "<h1 class='text-center text-red-500'>Laporan tidak boleh kosong</h1>";
                                } else
                                    if ($_GET['pesan'] == "berhasil") {
                                        echo "<h1 class='text-center text-green-500'>Laporan berhasil terkirim. Terima kasih sudah melaporkan.</h1>";
                                    } else
                                        if ($_GET['pesan'] == "ekstensi_error") {
                                            echo "<h1 class='text-center text-red-500'>Mohon kirimkan foto dengan ekstensi JPEG, JPG, atau PNG.</h1>";
                                        }
                        }
                        ?>
                        <textarea
                            class="resize-none border border-gray-300 rounded-md mt-2 w-full bg-gray-50 p-3 focus:outline-1"
                            type="text" name="laporan" id="laporan" rows="13"></textarea>
                    </div>
                    <div class="mb-6">
                        <label for="upload">Tambahkan Foto (Jika ada)</label><br>
                        <div class="flex items-center border border-gray-300 rounded overflow-hidden w-full mt-2">
                            <label for="upload" class="flex items-center bg-gray-300 px-3 py-2 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 7h2l1.5-2h11l1.5 2h2a2 2 0 012 2v9a2 2 0 01-2 2H3a2 2 0 01-2-2V9a2 2 0 012-2zm9 1a4 4 0 100 8 4 4 0 000-8z" />
                                </svg>
                            </label>
                            <input type="file" id="upload" name="foto"
                                class="file:hidden bg-gray-50 w-full text-sm text-gray-500 px-4 py-2 cursor-pointer">
                        </div>
                    </div>
                    <button type="submit" name="submit"
                        class="bg-red-600 w-full py-2 text-white font-medium rounded cursor-pointer">Submit</button>
                </div>
            </form>

            <div class="justify-items-center text-sm md:text-base scale-50 md:scale-100 space-y-1 md:space-y-0">
                <h1 class="text-5xl font-bold text-red-600">Alur Proses</h1>
                <div class="mt-5 flex items-center gap-5">
                    <div class="justify-items-center text-sm md:text-base space-y-1 md:space-y-0">
                        <svg fill="#FF0000" width="30px" height="30px" viewBox="0 0 32 32" version="1.1"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16 3c-7.18 0-13 5.82-13 13s5.82 13 13 13 13-5.82 13-13-5.82-13-13-13zM17.757 22.536h-2.469v-9.305c-0.901 0.841-1.964 1.463-3.188 1.867v-2.234c0.644-0.211 1.344-0.612 2.099-1.202s1.273-1.278 1.555-2.064h2.003v12.938z"
                                fill="#FF0000">
                            </path>
                        </svg>
                        <svg width="70px" height="70px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M19.186 2.09c.521.25 1.136.612 1.625 1.101.49.49.852 1.104 1.1 1.625.313.654.11 1.408-.401 1.92l-7.214 7.213c-.31.31-.688.541-1.105.675l-4.222 1.353a.75.75 0 0 1-.943-.944l1.353-4.221a2.75 2.75 0 0 1 .674-1.105l7.214-7.214c.512-.512 1.266-.714 1.92-.402zm.211 2.516a3.608 3.608 0 0 0-.828-.586l-6.994 6.994a1.002 1.002 0 0 0-.178.241L9.9 14.102l2.846-1.496c.09-.047.171-.107.242-.178l6.994-6.994a3.61 3.61 0 0 0-.586-.828zM4.999 5.5A.5.5 0 0 1 5.47 5l5.53.005a1 1 0 0 0 0-2L5.5 3A2.5 2.5 0 0 0 3 5.5v12.577c0 .76.082 1.185.319 1.627.224.419.558.754.977.978.442.236.866.318 1.627.318h12.154c.76 0 1.185-.082 1.627-.318.42-.224.754-.559.978-.978.236-.442.318-.866.318-1.627V13a1 1 0 1 0-2 0v5.077c0 .459-.021.571-.082.684a.364.364 0 0 1-.157.157c-.113.06-.225.082-.684.082H5.923c-.459 0-.57-.022-.684-.082a.363.363 0 0 1-.157-.157c-.06-.113-.082-.225-.082-.684V5.5z"
                                fill="#FF0000" />
                        </svg>
                        <h3 class="text-red-500 font-bold text-xl text-center">Penulisan<br>Laporan</h3>
                    </div>
                    <svg width="80px" height="80px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 12H20M20 12L16 8M20 12L16 16" stroke="#FF0000" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="justify-items-center text-sm md:text-base space-y-1 md:space-y-0">
                        <svg fill="#FF0000" width="30px" height="30px" viewBox="0 0 32 32" version="1.1"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16 3c-7.18 0-13 5.82-13 13s5.82 13 13 13 13-5.82 13-13-5.82-13-13-13zM20.342 20.426v2.297h-8.656c0.093-0.867 0.374-1.688 0.843-2.465 0.468-0.776 1.393-1.807 2.774-3.090 1.111-1.037 1.793-1.74 2.045-2.109 0.34-0.51 0.51-1.014 0.51-1.512 0-0.551-0.147-0.975-0.441-1.271s-0.7-0.444-1.219-0.444c-0.512 0-0.92 0.156-1.223 0.467s-0.478 0.827-0.523 1.549l-2.469-0.247c0.146-1.359 0.605-2.335 1.378-2.928s1.739-0.888 2.898-0.888c1.27 0 2.268 0.343 2.994 1.028s1.089 1.538 1.089 2.557c0 0.58-0.104 1.132-0.312 1.656s-0.537 1.074-0.988 1.647c-0.299 0.38-0.839 0.929-1.621 1.644-0.781 0.714-1.276 1.188-1.484 1.422s-0.376 0.463-0.505 0.686h4.91z">
                            </path>
                        </svg>
                        <svg fill="#FF0000" width="70px" height="70px" viewBox="0 0 32 32" id="icon"
                            xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <style>
                                    .cls-1 {
                                        fill: none;
                                    }
                                </style>
                            </defs>
                            <title>certificate--check</title>
                            <rect x="6" y="16" width="6" height="2" />
                            <rect x="6" y="12" width="10" height="2" />
                            <rect x="6" y="8" width="10" height="2" />
                            <path d="M14,26H4V6H28V16h2V6a2,2,0,0,0-2-2H4A2,2,0,0,0,2,6V26a2,2,0,0,0,2,2H14Z" />
                            <polygon points="22 25.59 19.41 23 18 24.41 22 28.41 30 20.41 28.59 19 22 25.59" />
                            <rect id="_Transparent_Rectangle_" data-name="&lt;Transparent Rectangle&gt;" class="cls-1"
                                width="32" height="32" />
                        </svg>
                        <h3 class="text-red-500 font-bold text-xl text-center">Verifikasi<br>
                            <h3 class="text-white font-bold text-xl">.</h3>
                        </h3>
                    </div>
                    <svg width="80px" height="80px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 12H20M20 12L16 8M20 12L16 16" stroke="#FF0000" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="justify-items-center text-sm md:text-base space-y-1 md:space-y-0">
                        <svg fill="#FF0000" width="30px" height="30px" viewBox="0 0 32 32" version="1.1"
                            xmlns="http://www.w3.org/2000/svg">
                            <title>number12</title>
                            <path
                                d="M16 3c-7.18 0-13 5.82-13 13s5.82 13 13 13 13-5.82 13-13-5.82-13-13-13zM18.995 21.357c-0.826 0.797-1.854 1.194-3.086 1.194-1.166 0-2.133-0.335-2.9-1.005-0.769-0.67-1.214-1.545-1.337-2.627l2.391-0.289c0.076 0.607 0.281 1.071 0.616 1.393 0.333 0.321 0.738 0.482 1.213 0.482 0.51 0 0.939-0.194 1.289-0.582 0.348-0.387 0.522-0.909 0.522-1.566 0-0.621-0.167-1.115-0.501-1.479-0.335-0.364-0.742-0.545-1.223-0.545-0.317 0-0.695 0.062-1.136 0.184l0.272-1.997c0.668 0.018 1.178-0.127 1.529-0.434s0.526-0.715 0.526-1.224c0-0.433-0.128-0.777-0.385-1.035-0.258-0.257-0.599-0.386-1.025-0.386-0.421 0-0.779 0.146-1.077 0.438s-0.479 0.72-0.544 1.281l-2.281-0.386c0.158-0.782 0.397-1.407 0.717-1.875s0.765-0.835 1.336-1.103 1.212-0.401 1.921-0.401c1.213 0 2.186 0.387 2.918 1.161 0.604 0.633 0.905 1.348 0.905 2.145 0 1.131-0.619 2.034-1.858 2.708 0.739 0.158 1.33 0.513 1.772 1.063 0.443 0.551 0.664 1.215 0.664 1.994 0.001 1.132-0.412 2.095-1.238 2.891z">
                            </path>
                        </svg>
                        <svg width="70px" height="70px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                            fill="none">
                            <path fill="#FF0000" fill-rule="evenodd"
                                d="M10 3a7 7 0 100 14 7 7 0 000-14zm-9 7a9 9 0 1118 0 9 9 0 01-18 0zm10.01 4a1 1 0 01-1 1H10a1 1 0 110-2h.01a1 1 0 011 1zM11 6a1 1 0 10-2 0v5a1 1 0 102 0V6z" />
                        </svg>
                        <h3 class="text-red-500 font-bold text-xl text-center">Tindak<br>Lanjut
                        </h3>
                    </div>
                    <svg width="80px" height="80px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 12H20M20 12L16 8M20 12L16 16" stroke="#FF0000" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="justify-items-center text-sm md:text-base space-y-1 md:space-y-0">
                        <svg fill="#FF0000" width="30px" height="30px" viewBox="0 0 32 32" version="1.1"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16.359 17.583v-4.405l-2.971 4.405h2.971zM16 3c-7.18 0-13 5.82-13 13s5.82 13 13 13 13-5.82 13-13-5.82-13-13-13zM20.344 19.739h-1.594v2.595h-2.391v-2.595h-5.281v-2.147l5.598-8.196h2.074v8.187h1.594v2.156z">
                            </path>
                        </svg>
                        <svg fill="#FF0000" width="70px" height="70px" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M3.5 3.75a.25.25 0 01.25-.25h13.5a.25.25 0 01.25.25v10a.75.75 0 001.5 0v-10A1.75 1.75 0 0017.25 2H3.75A1.75 1.75 0 002 3.75v16.5c0 .966.784 1.75 1.75 1.75h7a.75.75 0 000-1.5h-7a.25.25 0 01-.25-.25V3.75z" />
                            <path
                                d="M6.25 7a.75.75 0 000 1.5h8.5a.75.75 0 000-1.5h-8.5zm-.75 4.75a.75.75 0 01.75-.75h4.5a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75zm16.28 4.53a.75.75 0 10-1.06-1.06l-4.97 4.97-1.97-1.97a.75.75 0 10-1.06 1.06l2.5 2.5a.75.75 0 001.06 0l5.5-5.5z" />
                        </svg>
                        <h3 class="text-red-500 font-bold text-xl text-center">Tanggapan<br>
                            <h3 class="text-white font-bold text-xl">.</h3>
                        </h3>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <?php
    include './footer.php';
    ?>
</body>

</html>