<?php
/**
 * pendaftaran.php
 * View untuk formulir pendaftaran magang dengan sistem Multi-Step.
 */

global $is_logged_in, $user_role;

/**
 * 1. PROTEKSI AKSES & OTORISASI
 */
if (!$is_logged_in || $user_role !== 'user') {
    $_SESSION['auth_error'] = "Anda harus login sebagai Pendaftar untuk mengakses formulir.";
    header('Location: ' . url_for('login'));
    exit;
}

require_once ROOT_PATH . 'app/models/Pendaftar.php';
require_once ROOT_PATH . 'app/models/Internship.php';

/**
 * 2. PRE-LOADING DATA PROFIL & VALIDASI LOWONGAN
 */
$user_id        = $_SESSION['user_id'];
$profile        = Pendaftar::getProfileByUserId($user_id);
$existing_nik   = $profile['NIK'] ?? '';
$existing_email = $profile['email'] ?? $_SESSION['user_email'] ?? ''; 

// Validasi ID Lowongan dari parameter URL
$lowongan_id = filter_var($_GET['lowongan_id'] ?? null, FILTER_VALIDATE_INT);
$lowongan    = $lowongan_id ? Internship::getPostingById($lowongan_id) : false;

if (!$lowongan) {
    $_SESSION['message'] = [
        'type' => 'error', 
        'text' => "ID Lowongan tidak valid atau lowongan tidak ditemukan. Silakan pilih lowongan kembali."
    ];
    header('Location: ' . url_for('info'));
    exit;
}

// Konfigurasi metadata halaman
$page_title = "Pendaftaran Magang - " . htmlspecialchars($lowongan['posisi']);

/**
 * 3. MANAJEMEN STATE FORM (Error Handling & Sticky Data)
 */
$success_message = $_SESSION['success_message'] ?? null;
$form_errors     = $_SESSION['form_errors'] ?? [];
$old_data        = $_SESSION['form_data'] ?? [];

// Flash Session Clean-up: Menghapus data sesi setelah dimuat ke variabel
unset($_SESSION['success_message']);
unset($_SESSION['form_errors']);
unset($_SESSION['form_data']);
?>

<div class="form-title">Pendaftaran Internship: <?= htmlspecialchars($lowongan['posisi']) ?></div>

<div class="form-wrapper">
    
    <?php if (!empty($form_errors)): ?>
        <div class="session-status error-status">
            <h3>Pendaftaran Gagal:</h3>
            <ul>
                <?php foreach ($form_errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <form id="multiStepForm" 
              method="POST" 
              action="index.php?page=submit_pendaftaran" 
              enctype="multipart/form-data" 
              novalidate>
            
            <input type="hidden" name="lowongan_id" value="<?= htmlspecialchars($lowongan_id) ?>">

            <div class="form-step active">
                <div class="form-header">1. Data Diri</div>

                <div class="input-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" placeholder="Masukkan nama lengkap" 
                           value="<?= htmlspecialchars($old_data['nama'] ?? $_SESSION['user_name'] ?? '') ?>" required>
                </div>
                
                <div class="input-group">
                    <label>NIK (Nomor Induk Kependudukan) *</label>
                    <input type="text" name="NIK" placeholder="Masukkan 16 digit NIK" 
                           value="<?= htmlspecialchars($old_data['NIK'] ?? $existing_nik) ?>" 
                           maxlength="16" pattern="\d{16}" required 
                           title="NIK harus 16 digit angka.">
                    <small class="form-text text-muted">NIK ini akan disimpan ke profil Anda.</small>
                </div>
                
                <div class="input-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" required>
                        <option value ="" disabled selected hidden>Pilih</option>
                        <option value ="lakilaki" <?= ($old_data['jenis_kelamin'] ?? '') === 'lakilaki' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value ="perempuan" <?= ($old_data['jenis_kelamin'] ?? '') === 'perempuan' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" 
                           value="<?= htmlspecialchars($old_data['tanggal_lahir'] ?? '') ?>" required>
                </div>

                <div class="input-group">
                    <label>Alamat Domisili</label>
                    <input type="text" name="alamat" placeholder="Alamat" 
                           value="<?= htmlspecialchars($old_data['alamat'] ?? '') ?>" required>
                </div>

                <div class="input-group">
                    <label>Nomor HP / WhatsApp</label>
                    <input type="text" name="nomor_hp" placeholder="08xxxxxxxxxx" 
                           value="<?= htmlspecialchars($old_data['nomor_hp'] ?? '') ?>" required> 
                </div>

                <div class="input-group">
                    <label>Email Aktif</label>
                    <input type="email" name="email" placeholder="example@gmail.com" 
                           value="<?= htmlspecialchars($old_data['email'] ?? $existing_email) ?>" required>
                </div>

                <div class="form-navigation">
                    <button type="button" class="btn-next">Selanjutnya</button>
                </div>
            </div>

            <div class="form-step">
                <div class="form-header">2. Data Pendidikan</div>

                <div class="input-group">
                    <label>Pendidikan Terakhir</label>
                    <select name="pendidikan" required>
                        <option value ="" disabled selected hidden>Pilih</option>
                        <option value = "SD" <?= ($old_data['pendidikan'] ?? '') === 'SD' ? 'selected' : '' ?>>SD</option>
                        <option value = "SMP" <?= ($old_data['pendidikan'] ?? '') === 'SMP' ? 'selected' : '' ?>>SMP</option>
                        <option value = "SMA / SMK / MA" <?= ($old_data['pendidikan'] ?? '') === 'SMA / SMK / MA' ? 'selected' : '' ?>>SMA / SMK / MA</option>
                        <option value = "Diploma D4" <?= ($old_data['pendidikan'] ?? '') === 'Diploma D4' ? 'selected' : '' ?>>Diploma D4 / D3</option>
                        <option value = "Sarjana S1" <?= ($old_data['pendidikan'] ?? '') === 'Sarjana S1' ? 'selected' : '' ?>>Sarjana S1</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>Asal sekolah / Universitas</label>
                    <input type="text" name="instansi" placeholder="Ex: Universitas Indonesia / SMAN 1 Surabaya" 
                           value="<?= htmlspecialchars($old_data['instansi'] ?? '') ?>" required>
                </div>

                <div class="input-group">
                    <label>Program studi</label>
                    <input type="text" name="prodi" placeholder="Nama program studi" 
                           value="<?= htmlspecialchars($old_data['prodi'] ?? '') ?>" required>
                </div>

                <div class="input-group">
                    <label>Jurusan</label>
                    <input type="text" name="jurusan" placeholder="Nama Jurusan" 
                           value="<?= htmlspecialchars($old_data['jurusan'] ?? '') ?>" required>
                </div>

                <div class="input-group">
                    <label>Semester</label>
                    <input type="text" name="semester" placeholder="Ex: 7, jika bukan mahasiswa isi -" 
                           value="<?= htmlspecialchars($old_data['semester'] ?? '') ?>" required>
                </div>

                <div class="input-group">
                    <label>IPK (opsional)</label>
                    <input type="text" name="ipk" placeholder="Ex: 3.75" 
                           value="<?= htmlspecialchars($old_data['ipk'] ?? '') ?>">
                </div>

                <div class="form-navigation">
                    <button type="button" class="btn-prev">Sebelumnya</button>
                    <button type="button" class="btn-next">Selanjutnya</button>
                </div>
            </div>

            <div class="form-step">
                <div class="form-header">3. Informasi Magang</div>

                <div class="input-group">
                    <label>Posisi / Jabatan yang dilamar</label>
                    <input type="text" name="jabatan" value="<?= htmlspecialchars($old_data['jabatan'] ?? '') ?>" required>
                </div>

                <div class="input-group">
                    <label>Alasan mengikuti magang</label>
                    <input type="text" name="alasan" value="<?= htmlspecialchars($old_data['alasan'] ?? '') ?>" required>
                </div>

                <div class="input-group">
                    <label>Sumber info lowongan</label>
                    <select name="sumber" required>
                        <option value="" disabled selected hidden>Pilih</option>
                        <option value="Social media (Instagram, Facebook, X)" <?= ($old_data['sumber'] ?? '') === 'Social media (Instagram, Facebook, X)' ? 'selected' : '' ?>>Social media (Instagram, Facebook, X)</option>
                        <option value="Media Partner" <?= ($old_data['sumber'] ?? '') === 'Media Partner' ? 'selected' : '' ?>>Media Partner</option>
                        <option value="Website Internship" <?= ($old_data['sumber'] ?? '') === 'Website Internship' ? 'selected' : '' ?>>Website Internship</option>
                    </select>
                </div>

                <div class="form-navigation">
                    <button type="button" class="btn-prev">Sebelumnya</button>
                    <button type="button" class="btn-next">Selanjutnya</button>
                </div>
            </div>

            <div class="form-step">
                <div class="form-header">4. Dokumen Lampiran</div>

                <div class="input-group">
                    <label>Upload CV (Format PDF)</label>
                    <input type="file" id="cvFile" name="cv" accept=".pdf" required>
                </div>

                <div class="input-group">
                    <label>Portofolio (Opsional)</label>
                    <input type="file" id="portfolioFile" name="portofolio" accept=".pdf">
                </div>

                <div class="form-navigation">
                    <button type="button" class="btn-prev">Sebelumnya</button>
                    <button type="submit" class="btn-submit">Kirim</button>
                </div>
            </div>
        </form>
    </div>
</div>