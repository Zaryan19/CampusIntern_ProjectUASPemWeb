<?php
/**
 * views/pages/edit_internship.php
 * Halaman form untuk Perusahaan mengedit lowongan magang yang sudah ada.
 */

global $is_logged_in, $user_role, $user_name; 

// Pengecekan Akses (Lapisan keamanan tambahan)
if ($user_role !== 'company' || !$is_logged_in) {
    header('Location: ' . url_for('halaman_utama'));
    exit;
}

// 1. Ambil ID dan Cek Keberadaan Lowongan
$posting_id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
$company_id = $_SESSION['user_id'];

if (!$posting_id) {
    $_SESSION['internship_message'] = ['type' => 'error', 'text' => "ID Lowongan tidak ditemukan."];
    header('Location: ' . url_for('company_dashboard'));
    exit();
}

// Ambil data lowongan lama
$old_post = Internship::getPostingById($posting_id);

// 2. Verifikasi Kepemilikan Lowongan
if (!$old_post || $old_post['company_id'] != $company_id) {
    $_SESSION['internship_message'] = ['type' => 'error', 'text' => "Lowongan tidak ditemukan atau Anda tidak memiliki izin untuk mengeditnya."];
    header('Location: ' . url_for('company_dashboard'));
    exit();
}

// 3. Muat Data Input (Prioritas: Sesi error > Data Lama)
$message = $_SESSION['internship_message'] ?? null;
unset($_SESSION['internship_message']);
$old_input = $_SESSION['old_input'] ?? [];
unset($_SESSION['old_input']);

// Fungsi helper untuk mengisi ulang input, memprioritaskan input error/lama
function old_edit_val($key, $old_input, $old_post) {
    // Jika ada input lama dari error sesi, gunakan itu. Jika tidak, gunakan data dari database.
    return htmlspecialchars($old_input[$key] ?? $old_post[$key] ?? '');
}

$page_title = "Edit Lowongan: " . $old_post['posisi'];
?>

<div class="form-container-editintern">
    <h1>Edit Lowongan Magang</h1>

    <?php if ($message): ?>
        <div class="alert alert-<?= $message['type'] ?>">
            <?= htmlspecialchars($message['text']) ?>
        </div>
    <?php endif; ?>

    <form action="<?= url_for('internship_update') . '&id=' . $posting_id ?>" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="old_logo_url" value="<?= htmlspecialchars($old_post['logo_url']) ?>">

        <div class="form-group">
            <label>Perusahaan</label>
            <input type="text" value="<?= htmlspecialchars($old_post['perusahaan']) ?>" disabled>
        </div>
        
        <div class="form-group">
            <label for="posisi">Posisi Lowongan *</label>
            <input type="text" id="posisi" name="posisi" value="<?= old_edit_val('posisi', $old_input, $old_post) ?>" required>
        </div>

        <div class="form-group">
            <label for="kualifikasi_jurusan">Kualifikasi Jurusan (Pisahkan dengan koma)</label>
            <input type="text" id="kualifikasi_jurusan" name="kualifikasi_jurusan" value="<?= old_edit_val('kualifikasi_jurusan', $old_input, $old_post) ?>">
        </div>

        <div class="form-group">
            <label for="ringkasan">Ringkasan Lowongan (Max 255 karakter)</label>
            <textarea id="ringkasan" name="ringkasan" rows="3" maxlength="255"><?= old_edit_val('ringkasan', $old_input, $old_post) ?></textarea>
        </div>

        <div class="form-group">
            <label for="deskripsi_pekerjaan">Deskripsi Pekerjaan Detail *</label>
            <textarea id="deskripsi_pekerjaan" name="deskripsi_pekerjaan" rows="6" required><?= old_edit_val('deskripsi_pekerjaan', $old_input, $old_post) ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="requirements">Persyaratan Utama (Gunakan poin atau baris baru)</label>
            <textarea id="requirements" name="requirements" rows="5"><?= old_edit_val('requirements', $old_input, $old_post) ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="durasi">Durasi Magang (Contoh: 6 Bulan)</label>
                <input type="text" id="durasi" name="durasi" value="<?= old_edit_val('durasi', $old_input, $old_post) ?>">
            </div>
            <div class="form-group">
                <label for="lokasi_penempatan">Lokasi Penempatan</label>
                <input type="text" id="lokasi_penempatan" name="lokasi_penempatan" value="<?= old_edit_val('lokasi_penempatan', $old_input, $old_post) ?>">
            </div>
        </div>

        <?php 
            // Konversi tanggal database (YYYY-MM-DD HH:MM:SS) ke format input date (YYYY-MM-DD)
            $start_date_val = date('Y-m-d', strtotime($old_post['tanggal_mulai'] ?? ''));
            $end_date_val = date('Y-m-d', strtotime($old_post['tanggal_selesai'] ?? ''));
        ?>
        <div class="form-row">
            <div class="form-group">
                <label for="tanggal_mulai">Tanggal Mulai Pendaftaran *</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" 
                       value="<?= old_edit_val('tanggal_mulai', $old_input, ['tanggal_mulai' => $start_date_val]) ?>" required>
            </div>
            <div class="form-group">
                <label for="tanggal_selesai">Tanggal Selesai Pendaftaran (Deadline) *</label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai" 
                       value="<?= old_edit_val('tanggal_selesai', $old_input, ['tanggal_selesai' => $end_date_val]) ?>" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="website">Link Website Perusahaan (Opsional)</label>
            <input type="url" id="website" name="website" value="<?= old_edit_val('website', $old_input, $old_post) ?>">
        </div>
        <div class="form-group">
            <label for="instagram_link">Link Instagram Perusahaan (Opsional)</label>
            <input type="url" id="instagram_link" name="instagram_link" value="<?= old_edit_val('instagram_link', $old_input, $old_post) ?>">
        </div>

        <div class="form-group">
            <label>Logo Saat Ini:</label>
            <img src="<?= htmlspecialchars($old_post['logo_url']) ?>" alt="Logo Lama" style="max-width: 100px; display: block; margin-bottom: 10px;">
        </div>
        <div class="form-group">
            <label for="logo_file">Ganti Logo (Kosongkan jika tidak ingin diubah)</label>
            <input type="file" id="logo_file" name="logo_file" accept="image/*">
        </div>

        <button type="submit" class="btn btn-submit btn-update">Simpan Perubahan Lowongan</button>
    </form>
</div>