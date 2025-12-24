<?php

/**
 * auth_register.php
 * Handler utama untuk memproses registrasi pengguna baru.
 * File ini menangani validasi input, pembuatan akun, dan inisialisasi profil awal.
 */

// Proteksi akses: Memastikan skrip hanya diproses melalui metode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . url_for('register'));
    exit();
}

/**
 * 1. LOAD DEPENDENSI
 * Memuat Model User untuk interaksi data akun dan autentikasi.
 */
require_once ROOT_PATH . 'app/models/User.php'; 

/**
 * 2. AMBIL DAN SANITASI INPUT
 * Membersihkan data input untuk keamanan dan konsistensi data.
 */
$name                  = trim($_POST['name'] ?? '');
$email                 = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$password              = $_POST['password'] ?? '';
$password_confirmation = $_POST['password_confirmation'] ?? '';
$role                  = $_POST['role'] ?? 'user'; // Menangani pemilihan peran (User/Company)

$errors = [];

/**
 * 3. VALIDASI INPUT FORM
 * Melakukan pengecekan kepatuhan data terhadap aturan bisnis sistem.
 */
if (empty($name) || empty($email) || empty($password) || empty($password_confirmation)) {
    $errors[] = "Semua bidang wajib diisi.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Format email tidak valid.";
}

if (strlen($password) < 8) {
    $errors[] = "Password minimal 8 karakter.";
}

if ($password !== $password_confirmation) {
    $errors[] = "Konfirmasi password tidak cocok.";
}

// Validasi Role: Mencegah manipulasi nilai peran dari sisi klien
if (!in_array($role, ['user', 'company'])) {
    $errors[] = "Pilihan peran tidak valid.";
}

/**
 * 4. VALIDASI DUPLIKASI DAN PROSES PENYIMPANAN
 */
if (empty($errors)) {
    // Memastikan email belum digunakan oleh pengguna lain
    if (User::findByEmail($email)) {
        $errors[] = "Email ini sudah terdaftar. Silakan login.";
    }
}

if (empty($errors)) {
    
    // Menyiapkan dataset untuk dikirim ke layer Model
    $data = [
        'name'     => $name,
        'email'    => $email,
        'password' => $password,
        'role'     => $role 
    ];
    
    // Eksekusi pembuatan akun melalui Model User
    $success = User::create($data);

    if ($success) {
        
        /**
         * 5. REGISTRASI BERHASIL: INISIALISASI SESI & PROFIL
         * Melakukan login otomatis setelah akun berhasil dibuat.
         */
        $user = User::findByEmail($email);
        
        if ($user) {
            
            // Logika spesifik untuk peran 'user' (Mahasiswa/Pendaftar)
            if ($user['role'] === 'user') {
                require_once ROOT_PATH . 'app/models/Pendaftar.php'; 
                
                // Membuat entri dasar pada tabel pendaftar untuk melengkapi profil nantinya
                $initial_profile_data = [
                    'user_id' => $user['id'],
                    'nama'    => $user['name'],
                    'email'   => $user['email']
                ];
                
                $profile_created = Pendaftar::createInitialProfile($initial_profile_data);
                
                if (!$profile_created) {
                    // Penanganan kegagalan pembuatan profil tanpa menghentikan proses login
                    $_SESSION['profile_error'] = "Peringatan: Gagal membuat entri profil awal. Lengkapi data di Dashboard Anda.";
                }
            }
            
            // Inisialisasi data session pengguna
            $_SESSION['user_id']         = $user['id'];
            $_SESSION['user_name']       = $user['name']; 
            $_SESSION['user_role']       = $user['role']; 
            $_SESSION['success_message'] = "Pendaftaran berhasil! Anda sudah login.";
            
            header('Location: ' . url_for('halaman_utama'));
            exit();
        }

    } else {
        $errors[] = "Gagal menyimpan pengguna ke database. Coba lagi.";
    }
}

/**
 * 6. PENANGANAN ERROR
 * Mengembalikan user ke form registrasi jika terjadi kesalahan validasi.
 */
if (!empty($errors)) {
    $_SESSION['auth_error'] = implode('<br>', $errors); 
    
    // Mekanisme "Sticky Form" agar input sebelumnya tidak hilang
    $_SESSION['old_input'] = [
        'name'  => $name,
        'email' => $email,
        'role'  => $role 
    ];

    header('Location: ' . url_for('register'));
    exit();
}