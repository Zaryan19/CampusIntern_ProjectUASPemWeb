<?php
/**
 * internship_delete.php
 * Handler untuk menghapus lowongan magang.
 */

global $is_logged_in, $user_role;

// 1. Pengecekan Akses
if (!$is_logged_in || $user_role !== 'company' || $_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Location: ' . url_for('halaman_utama'));
    exit();
}

// 2. Ambil ID Lowongan
$posting_id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
$company_id = $_SESSION['user_id'];

if (!$posting_id) {
    $_SESSION['internship_message'] = ['type' => 'error', 'text' => "ID Lowongan tidak valid."];
    header('Location: ' . url_for('company_dashboard'));
    exit();
}

// 3. Verifikasi Kepemilikan (Sangat Penting!)
$post = Internship::getPostingById($posting_id);

if (!$post || $post['company_id'] != $company_id) {
    $_SESSION['internship_message'] = ['type' => 'error', 'text' => "Anda tidak memiliki izin untuk menghapus lowongan ini."];
    header('Location: ' . url_for('company_dashboard'));
    exit();
}

// 4. Proses Penghapusan
if (Internship::deletePosting($posting_id)) {
    $_SESSION['internship_message'] = ['type' => 'success', 'text' => "Lowongan '{$post['posisi']}' berhasil dihapus."];
} else {
    $_SESSION['internship_message'] = ['type' => 'error', 'text' => "Gagal menghapus lowongan dari database."];
}

// 5. Redirect kembali ke dashboard
header('Location: ' . url_for('company_dashboard'));
exit();