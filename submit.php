<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Ambil data profil
        $tanggal_survei = $_POST['tanggal_survei'] ?? date('Y-m-d');
        $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
        $usia = intval($_POST['usia'] ?? 0);
        $pendidikan = $_POST['pendidikan'] ?? '';
        $pekerjaan = $_POST['pekerjaan'] ?? '';
        $pekerjaan_lainnya = $_POST['pekerjaan_lainnya'] ?? null;
        if ($pekerjaan !== 'Lainnya') {
            $pekerjaan_lainnya = null;
        }
        $jenis_layanan = $_POST['jenis_layanan'] ?? '';

        // Ambil jawaban u1 - u9
        $u1 = intval($_POST['u1'] ?? 0);
        $u2 = intval($_POST['u2'] ?? 0);
        $u3 = intval($_POST['u3'] ?? 0);
        $u4 = intval($_POST['u4'] ?? 0);
        $u5 = intval($_POST['u5'] ?? 0);
        $u6 = intval($_POST['u6'] ?? 0);
        $u7 = intval($_POST['u7'] ?? 0);
        $u8 = intval($_POST['u8'] ?? 0);
        $u9 = intval($_POST['u9'] ?? 0);
        $saran = trim($_POST['saran'] ?? '');

        // Validasi sederhana
        if (!$jenis_kelamin || !$usia || !$pendidikan || !$pekerjaan || !$jenis_layanan || !$u1 || !$u2 || !$u3 || !$u4 || !$u5 || !$u6 || !$u7 || !$u8 || !$u9) {
            die("Mohon lengkapi seluruh isian formulir survei. <a href='index.php'>Kembali</a>");
        }

        // Mulai transaksi database
        $pdo->beginTransaction();

        // 1. Simpan ke tabel responden
        $stmtResponden = $pdo->prepare("INSERT INTO responden (tanggal_survei, jenis_kelamin, usia, pendidikan, pekerjaan, pekerjaan_lainnya, jenis_layanan) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmtResponden->execute([$tanggal_survei, $jenis_kelamin, $usia, $pendidikan, $pekerjaan, $pekerjaan_lainnya, $jenis_layanan]);
        $responden_id = $pdo->lastInsertId();

        // 2. Simpan ke tabel jawaban_survei
        $stmtJawaban = $pdo->prepare("INSERT INTO jawaban_survei (responden_id, u1, u2, u3, u4, u5, u6, u7, u8, u9, saran) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtJawaban->execute([$responden_id, $u1, $u2, $u3, $u4, $u5, $u6, $u7, $u8, $u9, $saran]);

        $pdo->commit();

        // Redirect ke halaman terima kasih
        header("Location: terima-kasih.php");
        exit;

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        die("Terjadi kesalahan sistem: " . $e->getMessage() . " <a href='index.php'>Kembali</a>");
    }
} else {
    header("Location: index.php");
    exit;
}
?>
