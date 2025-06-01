<?php
include '../backend/auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="../output.css" rel="stylesheet" />
    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
</head>
<body>
    <nav class="bg-[#BA0000] px-6 md:px-20 py-4 flex items-center justify-between">
        <h1 class="text-white text-3xl md:text-4xl font-bold">PPM</h1>

        <!-- Hamburger Menu (Mobile) -->
        <div class="md:hidden">
            <button onclick="toggleMenu()" class="text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Menu (Desktop) -->
        <div class="hidden md:flex space-x-10 items-center">
            <a class="text-white font-medium" href="aboutaspage.php">About</a>
            <a class="text-white font-medium" href="profil-masyarakat.php">Profil</a>
            <a class="text-white font-medium" href="masyarakat.php">Lapor</a>
            <a class="text-white bg-[#570000] px-4 py-2 rounded-3xl font-medium" href="../backend/logout.php">Logout</a>
        </div>
    </nav>

    <!-- Menu (Mobile Dropdown) -->
    <div id="mobile-menu" class="md:hidden hidden bg-[#BA0000] px-6 py-4 space-y-2">
        <a class="block text-white font-medium" href="aboutaspage.php">About</a>
        <a class="block text-white font-medium" href="profil-masyarakat.php">Profil</a>
        <a class="block text-white font-medium" href="masyarakat.php">Lapor</a>
        <a class="text-white bg-[#570000] px-4 py-2 rounded-3xl font-medium inline-block" href="../backend/logout.php">Logout</a>
    </div>
</body>
</html>
