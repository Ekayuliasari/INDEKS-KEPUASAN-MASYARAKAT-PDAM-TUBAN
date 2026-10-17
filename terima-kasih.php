<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih - Survei Kepuasan Masyarakat</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0284c7',
                        primaryDark: '#0369a1',
                        primaryLight: '#e0f2fe',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    <!-- Header -->
    <header class="bg-primary shadow-md text-white">
        <div class="max-w-4xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 bg-white rounded-lg flex items-center justify-center overflow-hidden px-1 py-0.5">
                    <img src="assets/logo.jpeg" alt="Logo" class="h-8 w-auto object-contain">
                </div>
                <div>
                    <h1 class="font-bold text-sm sm:text-base leading-tight">PERUMDA AIR MINUM TIRTA LESTARI</h1>
                    <p class="text-xs text-sky-100">Kabupaten Tuban - Unit Layanan Cabang I Merakurak</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-md mx-auto px-4 py-16 flex-grow flex items-center justify-center w-full">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 text-center space-y-6 w-full">
            <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto text-3xl shadow-inner">
                ✅
            </div>
            <div class="space-y-2">
                <h2 class="text-2xl font-bold text-slate-900">Terima Kasih!</h2>
                <p class="text-slate-600 text-sm">
                    Partisipasi dan penilaian Anda dalam Survei Kepuasan Masyarakat (SKM) sangat berarti bagi peningkatan kualitas layanan PERUMDA Air Minum Tirta Lestari Cabang I Merakurak.
                </p>
            </div>
            <div class="pt-4">
                <a href="index.php" class="inline-block w-full bg-primary hover:bg-primaryDark text-white font-semibold py-3 px-6 rounded-xl transition-colors shadow-sm text-sm">
                    Isi Survei Baru
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white text-center py-6 text-xs">
        <div class="max-w-4xl mx-auto px-4 space-y-1">
            <p class="font-medium">PERUMDA Air Minum Tirta Lestari Kabupaten Tuban</p>
            <p class="text-slate-400">Unit Layanan Cabang I Merakurak &copy; <?php echo date('Y'); ?>. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
