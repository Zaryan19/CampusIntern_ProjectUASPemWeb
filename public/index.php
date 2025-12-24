<?php

/**
 * 1. KONFIGURASI SISTEM & KONEKSI DATABASE
 */
session_start();

// Definisi path absolut untuk memudahkan pemanggilan file dari berbagai level folder
define('ROOT_PATH', __DIR__ . '/../'); 

require_once ROOT_PATH . 'app/core/connection.php'; 
require_once ROOT_PATH . 'app/models/User.php';
require_once ROOT_PATH . 'app/models/Internship.php';


/**
 * 2. FUNGSI HELPER
 */
function url_for($page) {
    return 'index.php?page=' . urlencode($page);
}


/**
 * 3. MANAJEMEN SESI & OTENTIKASI
 */
$is_logged_in = isset($_SESSION['user_id']);
$user_name    = $_SESSION['user_name'] ?? 'Tamu';
$user_role    = $_SESSION['user_role'] ?? 'guest';


/**
 * 4. LOGIKA ROUTING & KONTROL AKSES
 */
$page   = $_GET['page'] ?? 'halaman_utama'; 
$action = $_GET['action'] ?? null; 

// Menangani permintaan logout
if ($action === 'logout') {
    session_unset();
    session_destroy();
    header('Location: ' . url_for('halaman_utama'));
    exit();
}

/**
 * Switch case ini berfungsi sebagai "Router" utama aplikasi
 */
switch ($page) {
    // Menampilkan halaman beranda
    case 'halaman_utama':
        $view_file = 'views/pages/halaman_utama.php'; 
        break;
        
    // Menampilkan daftar lowongan magang
    case 'info':
        $view_file = 'views/pages/info.php';
        break;
        
    // Menampilkan form login (Dicek: jika sudah login, lempar ke beranda)
    case 'login':
        if ($is_logged_in) { header('Location: ' . url_for('halaman_utama')); exit(); }
        $view_file = 'views/pages/login.php';
        break;

    // Memproses data login yang dikirim via POST
    case 'login_submit': 
        require_once ROOT_PATH . 'app/handlers/auth_login.php'; 
        exit(); 
      
    // Menampilkan form registrasi akun baru
    case 'register':
        if ($is_logged_in) { header('Location: ' . url_for('halaman_utama')); exit(); }
        $view_file = 'views/pages/register.php';
        break;

    // Memproses data registrasi akun baru
    case 'register_submit': 
        require_once ROOT_PATH . 'app/handlers/auth_register.php'; 
        exit(); 
        
    // Panel utama untuk pengguna dengan role perusahaan
    case 'company_dashboard':
        if ($user_role !== 'company') { header('Location: ' . url_for('halaman_utama')); exit(); }
        $view_file = 'views/pages/company_dashboard.php';
        break;

    // Panel utama untuk administrator (statistik dan rangkuman)
    case 'admin_dashboard':
        if ($user_role !== 'admin') { header('Location: ' . url_for('halaman_utama')); exit(); }
        $view_file = 'views/admin/dashboard.php';
        break;
    
    // Manajemen data pengguna oleh admin
    case 'admin_users':
        $view_file = 'views/admin/users.php';
        break;

    // Manajemen data perusahaan oleh admin
    case 'admin_company':
        $view_file = 'views/admin/company.php';
        break;

    // Manajemen seluruh lowongan magang oleh admin
    case 'admin_lowongan':
        $view_file = 'views/admin/lowongan.php';
        break;
        
    // Form bagi perusahaan untuk membuat lowongan baru
    case 'add_internship':
        if ($user_role !== 'company') { header('Location: ' . url_for('halaman_utama')); exit(); }
        $view_file = 'views/pages/add_internship.php';
        break;

    // Memproses data lowongan baru (Insert ke DB)
    case 'submit_internship': 
        require_once ROOT_PATH . 'app/handlers/internship_submit.php'; 
        exit();

    // Form bagi perusahaan untuk mengedit lowongan yang ada
    case 'edit_internship':
        if ($user_role !== 'company') { header('Location: ' . url_for('halaman_utama')); exit(); }
        $view_file = 'views/pages/edit_internship.php';
        break;
    
    // Memproses update data lowongan (Update ke DB)
    case 'internship_update': 
        require_once ROOT_PATH . 'app/handlers/internship_update.php'; 
        exit();
        
    // Memproses penghapusan lowongan oleh perusahaan
    case 'delete_internship':
        if ($user_role !== 'company') { header('Location: ' . url_for('halaman_utama')); exit(); }
        require_once ROOT_PATH . 'app/handlers/internship_delete.php'; 
        exit();

    // Form pendaftaran magang bagi mahasiswa
    case 'pendaftaran':
        $view_file = 'views/pages/pendaftaran.php';
        break;
        
    // Memproses pengiriman lamaran magang (Insert ke tabel pendaftaran)
    case 'submit_pendaftaran':
        require_once ROOT_PATH . 'app/handlers/form_pendaftaran.php';
        exit(); 
        
    // Halaman jika parameter 'page' tidak ditemukan dalam daftar di atas
    default:
        http_response_code(404);
        $view_file = 'views/pages/404.php';
        break;
}


/**
 * 5. RENDERING VIEW (LAYOUT ENGINE)
 */
$full_path = ROOT_PATH . $view_file;

if (file_exists($full_path)) {
    // Memisahkan Header/Footer khusus Admin agar tampilan Dashboard Admin berbeda
    if ($user_role === 'admin' && str_starts_with($view_file, 'views/admin')) {
        require_once ROOT_PATH . 'views/admin/includes/header.php';
        require_once $full_path;
        require_once ROOT_PATH . 'views/admin/includes/footer.php';
    } else {
        require_once ROOT_PATH . 'views/includes/header.php';
        require_once $full_path;
        require_once ROOT_PATH . 'views/includes/footer.php';
    }
} else {
    http_response_code(404);
    echo "<h1>404 Halaman Tidak Ditemukan</h1>";
}