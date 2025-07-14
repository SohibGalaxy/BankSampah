<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Selamat Datang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .bg-animated {
            background: linear-gradient(270deg, #facc15, #fbbf24, #f59e0b);
            background-size: 600% 600%;
            animation: gradientBG 10s ease infinite;
        }

        @keyframes gradientBG {
            0% {background-position: 0% 50%;}
            50% {background-position: 100% 50%;}
            100% {background-position: 0% 50%;}
        }
    </style>
</head>
<body class="h-screen bg-animated text-white flex flex-col justify-center items-center px-6" x-data="{ showCards: false }">

    <div class="text-center max-w-3xl">
        <h1 class="text-4xl md:text-6xl font-bold mb-6 drop-shadow-lg">Selamat Datang di Bank Sampah</h1>

        <!-- Hover trigger -->
        <p 
            class="text-lg md:text-xl mb-2 cursor-pointer transition"
            @mouseenter="showCards = true"
        >
            Aplikasi manajemen dan pelaporan sampah berbasis web
        </p>

        <!-- Cards muncul setelah hover (1 detik) -->
        <div 
            x-show="showCards" 
            x-transition.opacity.scale.duration.1000ms
            class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8"
        >
            <!-- Card 1 -->
            <div class="bg-blue-500 bg-opacity-90 p-6 rounded-xl shadow-lg backdrop-blur-md 
                        transform transition-transform duration-300 hover:-translate-y-2 hover:shadow-2xl">
                <h3 class="text-xl font-bold mb-2">Kelola Nasabah</h3>
                <p class="text-sm">Tambah, edit, dan pantau data nasabah bank sampah dengan mudah.</p>
            </div>

            <!-- Card 2 -->
            <div class="bg-green-500 bg-opacity-90 p-6 rounded-xl shadow-lg backdrop-blur-md 
                        transform transition-transform duration-300 hover:-translate-y-2 hover:shadow-2xl">
                <h3 class="text-xl font-bold mb-2">Catat Transaksi</h3>
                <p class="text-sm">Input setoran sampah dan penarikan saldo secara cepat & akurat.</p>
            </div>

            <!-- Card 3 -->
            <div class="bg-pink-500 bg-opacity-90 p-6 rounded-xl shadow-lg backdrop-blur-md 
                        transform transition-transform duration-300 hover:-translate-y-2 hover:shadow-2xl">
                <h3 class="text-xl font-bold mb-2">Notivikasi telegram</h3>
                <p class="text-sm">Dapatkan rekap laporan tabungan dan aktivitas sampah instan.</p>
            </div>
        </div>

        <!-- Tombol login -->
        <a href="{{ url('/admin') }}" class="mt-10 inline-block px-6 py-3 bg-white text-yellow-600 font-semibold rounded-full shadow-lg hover:bg-yellow-100 transition">
            Masuk ke Dashboard
        </a>
    </div>

</body>
</html>
