<?php
session_start();
require_once '../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Username atau password salah!";
        }
    } else {
        $error = "Mohon isi username dan password!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - IKM PERUMDA Air Minum Tirta Lestari</title>
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

    <header class="bg-primary shadow-md text-white">
        <div class="max-w-4xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 bg-white rounded-lg flex items-center justify-center overflow-hidden px-1 py-0.5">
                    <img src="../assets/logo.jpeg" alt="Logo" class="h-8 w-auto object-contain">
                </div>
                <div>
                    <h1 class="font-bold text-sm sm:text-base leading-tight">PERUMDA AIR MINUM TIRTA LESTARI</h1>
                    <p class="text-xs text-sky-100">Portal Admin - Survei Kepuasan Masyarakat</p>
                </div>
            </div>
            <div>
                <a href="../index.php" class="text-xs text-sky-100 hover:text-white underline">← Kembali ke Survei</a>
            </div>
        </div>
    </header>

    <main class="max-w-md mx-auto px-4 py-12 flex-grow flex items-center justify-center w-full">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 w-full space-y-6">
            <div class="text-center space-y-2">
                <span class="inline-block bg-primaryLight text-primary font-semibold text-xs px-3 py-1 rounded-full uppercase tracking-wider">Khusus Admin</span>
                <h2 class="text-2xl font-bold text-slate-900">Login Administrator</h2>
                <p class="text-xs text-slate-500">Masukkan akun admin untuk melihat rekapitulasi dan nilai IKM.</p>
            </div>

            <?php if ($error): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 text-xs p-3 rounded-lg text-center">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-slate-700 mb-1">Username</label>
                    <input type="text" id="username" name="username" required placeholder="Masukkan username..."
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary bg-white">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Masukkan password..."
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary bg-white">
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-primary hover:bg-primaryDark text-white font-semibold py-2.5 px-4 rounded-xl transition-colors shadow-sm text-sm">
                        Masuk Dashboard
                    </button>
                </div>
            </form>
            <div class="text-center text-xs text-slate-400 pt-2">
                Default: admin_merakurak / admin123
            </div>
        </div>
    </main>

    <footer class="bg-slate-900 text-white text-center py-6 text-xs">
        <div class="max-w-4xl mx-auto px-4 space-y-1">
            <p class="font-medium">PERUMDA Air Minum Tirta Lestari Kabupaten Tuban</p>
            <p class="text-slate-400">Unit Layanan Cabang I Merakurak &copy; <?php echo date('Y'); ?>. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
