<?php

/**
 * auth_login.php
 * Handler utama untuk memproses autentikasi pengguna.
 * File ini dipanggil melalui Front Controller (index.php) saat formulir login disubmit.
 */

// Proteksi akses: Memastikan skrip hanya diproses melalui metode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . url_for('login'));
    exit();
}

/**
 * 1. LOAD DEPENDENSI
 * Menggunakan model User untuk melakukan verifikasi data ke database.
 */
require_once ROOT_PATH . 'app/models/User.php'; 

/**
 * 2. AMBIL DAN SANITASI INPUT
 * Membersihkan data input untuk mencegah celah keamanan dasar.
 */
$email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']); // Pengecekan opsi "Ingat Saya"

/**
 * 3. VALIDASI FORM & VERIFIKASI KREDENSIAL
 */
if (empty($email) || empty($password)) {
    $_SESSION['auth_error'] = "Email dan password wajib diisi.";
    header('Location: ' . url_for('login'));
    exit();
}

// Memanggil method di model User untuk mencocokkan email dan password hash
$user = User::verifyCredentials($email, $password); 

if ($user) {

    /**
     * 4. VALIDASI STATUS AKUN (BANNED CHECK)
     * Memastikan pengguna yang valid secara kredensial tidak sedang dalam masa blokir.
     */
    if ($user['status'] === 'banned') {
        $_SESSION['auth_error'] = "Akun Anda telah dibanned. Silakan hubungi admin.";
        $_SESSION['old_input'] = ['email' => $email];
        header('Location: ' . url_for('login'));
        exit();
    }
    
    /**
     * 5. LOGIN BERHASIL: INISIALISASI SESI
     * Menyimpan informasi identitas dan peran (role) pengguna ke dalam session global.
     */
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['user_name'] = $user['name']; 
    $_SESSION['user_role'] = $user['role'];
    
    // (Opsional) Implementasi cookie untuk session jangka panjang
    if ($remember) {
        // Logika Persistent Login/Remember Me
    }

    /**
     * 6. PENGALIHAN HALAMAN BERDASARKAN PERAN (ROLE-BASED REDIRECT)
     * Mengarahkan pengguna ke dashboard yang sesuai dengan hak aksesnya.
     */
    switch ($user['role']) {
        case 'admin':
            header('Location: ' . url_for('admin_dashboard'));
            break;

        case 'company':
            header('Location: ' . url_for('halaman_utama'));
            break;

        case 'user':
        default:
            header('Location: ' . url_for('halaman_utama'));
            break;
    }

    exit();

} else {
    
    /**
     * 7. LOGIN GAGAL
     * Mengembalikan pengguna ke halaman login dengan pesan kesalahan.
     */
    $_SESSION['auth_error'] = "Kredensial tidak valid. Silakan coba lagi.";
    
    // Mempertahankan input email agar pengguna tidak perlu mengetik ulang
    $_SESSION['old_input'] = ['email' => $email];

    header('Location: ' . url_for('login'));
    exit();
}