<?php
/**
 * views/pages/company_dashboard.php
 * Dashboard untuk Perusahaan (Role: company).
 * Menampilkan daftar lowongan yang diposting oleh perusahaan ini.
 */

// Pastikan variabel global sudah tersedia dari index.php
global $is_logged_in, $user_role, $user_name; 

// --- 1. Pengecekan Akses (SANGAT PENTING) ---
// Walaupun sudah dicek di index.php, ini adalah lapisan keamanan tambahan.
if ($user_role !== 'company' || !$is_logged_in) {
    header('Location: ' . url_for('halaman_utama'));
    exit;
}

// --- 2. Ambil Data ---
$company_id = $_SESSION['user_id']; 

// Memastikan Model Internship dimuat
require_once ROOT_PATH . 'app/models/Internship.php'; 

// Menggunakan fungsi yang kita buat di Model Internship
$my_postings = Internship::getPostingsByCompanyId($company_id);

$page_title = "Dashboard Perusahaan";
$message = $_SESSION['internship_message'] ?? null;
unset($_SESSION['internship_message']);
?>

<div class="dashboard-container">
    <h1>Selamat Datang di Dashboard, <?= htmlspecialchars($user_name) ?>! 🏢</h1>
    <p>Kelola semua lowongan magang yang telah Anda publikasikan. Anda dapat membuat, melihat, mengedit, dan menghapus lowongan dari sini.</p>

    <?php if ($message): ?>
        <div class="alert alert-<?= $message['type'] ?>">
            <?= htmlspecialchars($message['text']) ?>
        </div>
    <?php endif; ?>
    
    <hr>
    
    <div class="dashboard-actions mb-4">
        <a href="<?= url_for('add_internship') ?>" class="btn btn-success btn-lg">
            <i data-feather="plus"></i> Posting Lowongan Baru
        </a>
    </div>

    <h2 class="mt-4">Daftar Lowongan Anda (Total: <?= count($my_postings) ?>)</h2>

    <?php if (empty($my_postings)): ?>
        <div class="alert alert-info">
            Anda belum memposting lowongan magang apapun. Silakan buat yang pertama!
        </div>
    <?php else: ?>
    
        <table class="table-striped posting-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Posisi</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($my_postings as $post): 
                    $deadline = strtotime($post['tanggal_selesai']);
                    $is_expired = $deadline < time();
                    $status_class = $is_expired ? 'danger' : 'success';
                ?>
                <tr>
                    <td>#<?= htmlspecialchars($post['id']) ?></td>
                    <td><?= htmlspecialchars($post['posisi']) ?></td>
                    <td><?= date('d M Y', $deadline) ?></td>
                    <td>
                        <span class="badge badge-<?= $status_class ?>">
                            <?= $is_expired ? 'Kadaluarsa' : 'Aktif' ?>
                        </span>
                    </td>
                    <td>
                        <a href="<?= url_for('edit_internship') . '&id=' . $post['id'] ?>" class="btn-edit btn-sm btn-warning">Edit</a>
                        
                        <button 
                            onclick="if(confirm('Yakin ingin menghapus lowongan ini? Tindakan ini tidak dapat dibatalkan.')) { window.location.href='<?= url_for('delete_internship') . '&id=' . $post['id'] ?>'; }" 
                            class="btn btn-sm btn-danger"
                        >
                            Hapus
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    <?php endif; ?>
</div>