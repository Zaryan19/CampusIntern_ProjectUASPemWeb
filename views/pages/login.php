<?php
/**
 * login.php
 * Konten utama untuk halaman Login.
 * File ini mengonversi tampilan Blade menjadi PHP Native murni.
 * Variabel global $is_logged_in, $user_name, dan url_for() sudah tersedia.
 */
$page_title = "Login"; 

// --- START TEMPLATE INCLUDES ---
require_once __DIR__ . '/../includes/header.php'; 

// Cek data error atau old input yang dikirim dari handler
$auth_error = $_SESSION['auth_error'] ?? null;
$old_input = $_SESSION['old_input'] ?? [];

// Bersihkan sesi setelah diambil
unset($_SESSION['auth_error']);
unset($_SESSION['old_input']);

// Logika pemuatan konten
?>

<!-- CONTAINER UTAMA HALAMAN (Mereplikasi <x-guest-layout>) -->
<div class="auth-page-container">
    
    <!-- KARTU FORMULIR -->
    <div class="auth-form-card">
    
        <?php if ($auth_error): ?>
            <!-- Menampilkan pesan error dari handler -->
            <div class="session-status error-status">
                <?= htmlspecialchars($auth_error) ?>
            </div>
        <?php endif; ?>

        <!-- Judul form -->
        <div class="form-title">Login</div>

        <!-- FORM LOGIC: action diarahkan ke handler POST via index.php -->
        <form method="POST" action="index.php?page=login_submit" class="login-form">
            
            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>

                <!-- Menggunakan old input dari sesi agar nilai tidak hilang saat validasi gagal -->
                <input id="email" type="email" name="email" 
                       value="<?= htmlspecialchars($old_input['email'] ?? '') ?>" 
                       required autofocus autocomplete="username"
                       class="form-input">

                <!-- Catatan: Pengecekan error spesifik (@error) diabaikan karena diringkas menjadi $auth_error -->
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="form-input">
            </div>

            <div class="form-actions">
                <!-- Tombol Register -->
                <a href="<?= url_for('register') ?>" class="btn-register">
                    Register
                </a>

                <!-- Tombol Submit -->
                <button type="submit" class="btn-login-submit">
                    Log in
                </button>
            </div>
        </form>
    </div>
</div>

<?php 
// --- END TEMPLATE INCLUDES ---
require_once __DIR__ . '/../includes/footer.php'; 
?>