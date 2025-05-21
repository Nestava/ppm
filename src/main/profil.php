<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <?php
    include './navbar_admin.php';
    ?>

    <main class="max-w-3xl mx-auto mt-5 p-6 bg-white shadow-md rounded-lg mb-10 border border-slate-300">
        <h1 class="text-3xl font-bold text-center mb-8">Profil</h1>
        <div class="bg-gray-50 p-6 rounded-md border border-slate-300">

            <div class="grid grid-cols-2 gap-y-4 text-sm text-gray-700">
                <p class="font-medium">ID</p>
                <p>: 1001</p>
                <p class="font-medium">Nama</p>
                <p>: Nama</p>
                <p class="font-medium">Username</p>
                <p>: Nama</p>
                <p class="font-medium">No. Telepon</p>
                <p>: 08210920112</p>
                <p class="font-medium">Password</p>
                <p>: admin123</p>
                <p class="font-medium">Status</p>
                <p>: Status</p>
            </div>

            <div class="mt-6">
                <label for="password" class="block font-medium mb-2">Ubah Password</label>
                <input type="password" id="password" class="w-full border rounded px-4 py-2"
                    placeholder="Masukkan password baru">
            </div>

            <div class="mt-6 text-right">
                <button class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Submit Perubahan</button>
            </div>
        </div>
    </main>

</body>

</html>