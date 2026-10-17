<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

require_once '../config/database.php';

// Ambil total responden
$stmtTotal = $pdo->query("SELECT COUNT(*) as total FROM responden");
$totalResponden = $stmtTotal->fetch()['total'];

// Ambil rata-rata per unsur
$stmtAvg = $pdo->query("SELECT 
    AVG(u1) as avg_u1, 
    AVG(u2) as avg_u2, 
    AVG(u3) as avg_u3, 
    AVG(u4) as avg_u4, 
    AVG(u5) as avg_u5, 
    AVG(u6) as avg_u6, 
    AVG(u7) as avg_u7, 
    AVG(u8) as avg_u8, 
    AVG(u9) as avg_u9 
    FROM jawaban_survei");
$avgs = $stmtAvg->fetch();

$u1 = $avgs['avg_u1'] ?? 0;
$u2 = $avgs['avg_u2'] ?? 0;
$u3 = $avgs['avg_u3'] ?? 0;
$u4 = $avgs['avg_u4'] ?? 0;
$u5 = $avgs['avg_u5'] ?? 0;
$u6 = $avgs['avg_u6'] ?? 0;
$u7 = $avgs['avg_u7'] ?? 0;
$u8 = $avgs['avg_u8'] ?? 0;
$u9 = $avgs['avg_u9'] ?? 0;

$totalRataRata = ($u1 + $u2 + $u3 + $u4 + $u5 + $u6 + $u7 + $u8 + $u9) / 9;
$nilaiIKM = $totalRataRata * 25;

// Tentukan Mutu Pelayanan & Kinerja
$mutu = '-';
$kinerja = '-';
if ($totalResponden > 0) {
    if ($nilaiIKM >= 88.31) {
        $mutu = 'A';
        $kinerja = 'Sangat Baik';
    } elseif ($nilaiIKM >= 76.61) {
        $mutu = 'B';
        $kinerja = 'Baik';
    } elseif ($nilaiIKM >= 65.00) {
        $mutu = 'C';
        $kinerja = 'Kurang Baik';
    } else {
        $mutu = 'D';
        $kinerja = 'Tidak Baik';
    }
}

// Ambil data responden terbaru beserta jawabannya & saran
$stmtList = $pdo->query("SELECT r.*, j.u1, j.u2, j.u3, j.u4, j.u5, j.u6, j.u7, j.u8, j.u9, j.saran 
FROM responden r 
JOIN jawaban_survei j ON r.id = j.responden_id 
ORDER BY r.tanggal_survei DESC, r.id DESC");
$listResponden = $stmtList->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Indeks Kepuasan Masyarakat</title>
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
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 bg-white rounded-lg flex items-center justify-center overflow-hidden px-1 py-0.5">
                    <img src="../assets/logo.jpeg" alt="Logo" class="h-8 w-auto object-contain">
                </div>
                <div>
                    <h1 class="font-bold text-sm sm:text-base leading-tight">PERUMDA AIR MINUM TIRTA LESTARI</h1>
                    <p class="text-xs text-sky-100">Dashboard Admin SKM - Cabang I Merakurak</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-xs text-sky-100 hidden sm:inline">Halo, <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong></span>
                <a href="logout.php" class="bg-sky-700 hover:bg-sky-800 text-white text-xs px-3 py-1.5 rounded-lg border border-sky-600 transition-colors">
                    🚪 Logout
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8 flex-grow w-full space-y-6">

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Responden -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Responden</p>
                    <h3 class="text-3xl font-bold text-slate-900 mt-1"><?php echo $totalResponden; ?></h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-sky-50 text-primary flex items-center justify-center text-2xl">
                    👥
                </div>
            </div>

            <!-- Nilai IKM -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Nilai IKM (Skala 100)</p>
                    <h3 class="text-3xl font-bold text-primary mt-1"><?php echo number_format($nilaiIKM, 2, ',', '.'); ?></h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl">
                    📊
                </div>
            </div>

            <!-- Mutu Pelayanan -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Mutu Pelayanan</p>
                    <h3 class="text-3xl font-bold text-slate-900 mt-1">Mutu <?php echo $mutu; ?> <span class="text-sm font-normal text-slate-500">(<?php echo $kinerja; ?>)</span></h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl">
                    ⭐
                </div>
            </div>
        </div>

        <!-- Rincian Nilai Per Unsur Pelayanan -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-4">
            <h3 class="text-lg font-bold text-slate-900">Rata-Rata Per Unsur Pelayanan</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex justify-between items-center">
                    <span>1. Kesesuaian Persyaratan</span>
                    <strong class="text-primary text-sm"><?php echo number_format($u1, 2, ',', '.'); ?></strong>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex justify-between items-center">
                    <span>2. Kemudahan Prosedur</span>
                    <strong class="text-primary text-sm"><?php echo number_format($u2, 2, ',', '.'); ?></strong>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex justify-between items-center">
                    <span>3. Kecepatan Waktu</span>
                    <strong class="text-primary text-sm"><?php echo number_format($u3, 2, ',', '.'); ?></strong>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex justify-between items-center">
                    <span>4. Kewajaran Biaya/Tarif</span>
                    <strong class="text-primary text-sm"><?php echo number_format($u4, 2, ',', '.'); ?></strong>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex justify-between items-center">
                    <span>5. Kesesuaian Produk</span>
                    <strong class="text-primary text-sm"><?php echo number_format($u5, 2, ',', '.'); ?></strong>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex justify-between items-center">
                    <span>6. Kompetensi Petugas</span>
                    <strong class="text-primary text-sm"><?php echo number_format($u6, 2, ',', '.'); ?></strong>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex justify-between items-center">
                    <span>7. Perilaku Petugas</span>
                    <strong class="text-primary text-sm"><?php echo number_format($u7, 2, ',', '.'); ?></strong>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex justify-between items-center">
                    <span>8. Kualitas Sarana & Prasarana</span>
                    <strong class="text-primary text-sm"><?php echo number_format($u8, 2, ',', '.'); ?></strong>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex justify-between items-center">
                    <span>9. Penanganan Pengaduan</span>
                    <strong class="text-primary text-sm"><?php echo number_format($u9, 2, ',', '.'); ?></strong>
                </div>
            </div>
        </div>

        <!-- Tabel Data Responden & Saran -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Daftar Responden & Saran</h3>
                    <p class="text-xs text-slate-500">Semua riwayat survei yang masuk dari masyarakat.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-100 text-slate-700 uppercase font-semibold">
                            <th class="p-3">No</th>
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">L/P</th>
                            <th class="p-3">Usia</th>
                            <th class="p-3">Pendidikan</th>
                            <th class="p-3">Pekerjaan</th>
                            <th class="p-3">Layanan</th>
                            <th class="p-3 text-center">Rata2 Nilai</th>
                            <th class="p-3">Kritik / Saran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <?php if (count($listResponden) > 0): ?>
                            <?php $no = 1; foreach ($listResponden as $row): 
                                $avgRes = ($row['u1'] + $row['u2'] + $row['u3'] + $row['u4'] + $row['u5'] + $row['u6'] + $row['u7'] + $row['u8'] + $row['u9']) / 9;
                            ?>
                                <tr class="hover:bg-slate-50">
                                    <td class="p-3 font-medium text-slate-900"><?php echo $no++; ?></td>
                                    <td class="p-3 text-slate-600"><?php echo date('d/m/Y', strtotime($row['tanggal_survei'])); ?></td>
                                    <td class="p-3 font-semibold"><?php echo $row['jenis_kelamin']; ?></td>
                                    <td class="p-3"><?php echo $row['usia']; ?> th</td>
                                    <td class="p-3"><?php echo htmlspecialchars($row['pendidikan']); ?></td>
                                    <td class="p-3"><?php echo htmlspecialchars($row['pekerjaan'] === 'Lainnya' ? $row['pekerjaan_lainnya'] : $row['pekerjaan']); ?></td>
                                    <td class="p-3 font-medium text-primary"><?php echo htmlspecialchars($row['jenis_layanan']); ?></td>
                                    <td class="p-3 text-center font-bold text-slate-900"><?php echo number_format($avgRes, 2); ?></td>
                                    <td class="p-3 text-slate-600 italic"><?php echo htmlspecialchars($row['saran'] ? $row['saran'] : '-'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="p-6 text-center text-slate-400">Belum ada data survei yang masuk.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white text-center py-6 text-xs mt-12">
        <div class="max-w-7xl mx-auto px-4 space-y-1">
            <p class="font-medium">PERUMDA Air Minum Tirta Lestari Kabupaten Tuban</p>
            <p class="text-slate-400">Unit Layanan Cabang I Merakurak &copy; <?php echo date('Y'); ?>. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
