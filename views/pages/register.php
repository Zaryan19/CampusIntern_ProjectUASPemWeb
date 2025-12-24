<?php
/**
 * register.php
 * Konten utama untuk halaman Registrasi.
 * File ini di-include oleh index.php.
 * Variabel global $is_logged_in, $user_name, dan url_for() sudah tersedia.
 */

// Set judul halaman untuk header.php
$page_title = "Daftar Akun Baru"; 

// Ambil error dan input lama dari sesi (diisi oleh auth_register.php jika gagal)
$auth_error = $_SESSION['auth_error'] ?? null;
$old_input = $_SESSION['old_input'] ?? [];

// Bersihkan sesi setelah diambil agar error/input tidak muncul di refresh berikutnya
unset($_SESSION['auth_error']);
unset($_SESSION['old_input']);
?>

<!-- CONTAINER UTAMA HALAMAN (Menggantikan <x-guest-layout>) -->
<!-- Kelas layout ini dikendalikan oleh CSS kustom Anda untuk centering dan background -->
<div class="auth-page-container">
    
    <!-- KARTU FORMULIR -->
    <div class="auth-form-card-regist">
    
    <?php if ($auth_error): ?>
        <div class="session-status error-status">
            <?= htmlspecialchars($auth_error) ?>
        </div>
    <?php endif; ?>

    <div class="form-title-regist">
        Daftar Akun Baru
    </div>

    <form method="POST" action="index.php?page=register_submit" class="register-form">
        
        <div class="form-group">
            <label class="form-label">Daftar Sebagai *</label>
            <div class="radio-group">
                <label>
                    <input type="radio" name="role" value="user" 
                           <?= (isset($old_input['role']) && $old_input['role'] == 'user') ? 'checked' : 'checked' ?>> 
                    Pendaftar Magang (Mahasiswa/Umum)
                </label>
                <label>
                    <input type="radio" name="role" value="company"
                           <?= (isset($old_input['role']) && $old_input['role'] == 'company') ? 'checked' : '' ?>> 
                    Perusahaan (Penyedia Magang)
                </label>
            </div>
            </div>

        <div class="form-group">
            <label for="name" class="form-label">Nama Lengkap / Nama Perusahaan</label>
            <input id="name" type="text" name="name" 
                   value="<?= htmlspecialchars($old_input['name'] ?? '') ?>" 
                   required autofocus autocomplete="name" class="form-input">
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" 
                   value="<?= htmlspecialchars($old_input['email'] ?? '') ?>" 
                   required autocomplete="username" class="form-input">
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" class="form-input">
        </div>

        <div class="form-group">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="form-input">
        </div>
            <div class="form-actions">
                <a class="login-link" href="<?= url_for('login') ?>">
                    Sudah terdaftar? (Login)
                </a>

                <button type="submit" class="btn-register-submit">
                    Register
                </button>
            </div>
        </form>
</div>



</div>
<!-- CONTAINER UTAMA HALAMAN (End of Content) -->