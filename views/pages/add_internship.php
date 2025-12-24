<?php
/**
 * views/pages/add_internship.php
 * Halaman form untuk Perusahaan menambah lowongan magang baru.
 */

global $is_logged_in, $user_role;

// Terapkan pengecekan akses ketat (walaupun sudah ada di index.php, ini lapisan keamanan tambahan)
if ($user_role !== 'company' || !$is_logged_in) {
    header('Location: ' . url_for('halaman_utama'));
    exit;
}

// Ambil pesan error/sukses dari sesi
$message = $_SESSION['internship_message'] ?? null;
unset($_SESSION['internship_message']);
$old_input = $_SESSION['old_input'] ?? [];
unset($_SESSION['old_input']);

// Fungsi helper untuk mengisi ulang input lama
function old_val($key, $old_input) {
    return htmlspecialchars($old_input[$key] ?? '');
}

$page_title = "Tambah Lowongan Magang";
?>

<div class="form-container-intern">
    <h1>Tambah Lowongan Magang Baru</h1>

    <?php if ($message): ?>
        <div class="alert alert-<?= $message['type'] ?>">
            <?= htmlspecialchars($message['text']) ?>
        </div>
    <?php endif; ?>

    <form action="<?= url_for('submit_internship') ?>" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label for="posisi">Posisi Lowongan *</label>
            <input type="text" id="posisi" name="posisi" value="<?= old_val('posisi', $old_input) ?>" required>
        </div>

        <div class="form-group">
            <label for="kualifikasi_jurusan">Kualifikasi Jurusan (Pisahkan dengan koma)</label>
            <input type="text" id="kualifikasi_jurusan" name="kualifikasi_jurusan" value="<?= old_val('kualifikasi_jurusan', $old_input) ?>">
        </div>

        <div class="form-group">
            <label for="ringkasan">Ringkasan Lowongan (Max 255 karakter, untuk tampilan Card)</label>
            <textarea id="ringkasan" name="ringkasan" rows="3" maxlength="255"><?= old_val('ringkasan', $old_input) ?></textarea>
        </div>

        <div class="form-group">
            <label for="deskripsi_pekerjaan">Deskripsi Pekerjaan Detail *</label>
            <textarea id="deskripsi_pekerjaan" name="deskripsi_pekerjaan" rows="6" required><?= old_val('deskripsi_pekerjaan', $old_input) ?></textarea>
        </div>

        <div class="form-group">
            <label for="requirements">Persyaratan Utama (Gunakan poin atau baris baru)</label>
            <textarea id="requirements" name="requirements" rows="5"><?= old_val('requirements', $old_input) ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="durasi">Durasi Magang (Contoh: 6 Bulan)</label>
                <input type="text" id="durasi" name="durasi" value="<?= old_val('durasi', $old_input) ?>">
            </div>
            <div class="form-group">
                <label for="lokasi_penempatan">Lokasi Penempatan</label>
                <input type="text" id="lokasi_penempatan" name="lokasi_penempatan" value="<?= old_val('lokasi_penempatan', $old_input) ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="tanggal_mulai">Tanggal Mulai Pendaftaran *</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="<?= old_val('tanggal_mulai', $old_input) ?>" required>
            </div>
            <div class="form-group">
                <label for="tanggal_selesai">Tanggal Selesai Pendaftaran (Deadline) *</label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="<?= old_val('tanggal_selesai', $old_input) ?>" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="website">Link Website Perusahaan (Opsional)</label>
            <input type="url" id="website" name="website" value="<?= old_val('website', $old_input) ?>">
        </div>
        <div class="form-group">
            <label for="instagram_link">Link Instagram Perusahaan (Opsional)</label>
            <input type="url" id="instagram_link" name="instagram_link" value="<?= old_val('instagram_link', $old_input) ?>">
        </div>
        
        <div class="form-group">
            <label for="logo_file">Logo Perusahaan (Gambar, Max 2MB)</label>
            <input type="file" id="logo_file" name="logo_file" accept="image/*">
        </div>

        <button type="submit" class="btn btn-submit">Posting Lowongan</button>
    </form>
</div>