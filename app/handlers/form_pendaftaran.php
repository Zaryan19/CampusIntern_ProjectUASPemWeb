<?php

/**
 * form_pendaftaran.php
 * Controller/Handler untuk memproses data formulir pendaftaran magang.
 * Memiliki fungsi ganda: Sinkronisasi profil pendaftar dan pencatatan log aplikasi.
 */

// Validasi metode akses (hanya mengizinkan metode POST)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . url_for('pendaftaran')); 
    exit();
}

/**
 * 0. KONTROL AKSES & DEKLARASI DEPENDENSI
 */
global $pdo, $is_logged_in, $user_role; 

// Verifikasi otentikasi dan hak akses role 'user'
if (!$is_logged_in || $user_role !== 'user') {
    $_SESSION['auth_error'] = "Anda harus login sebagai Pendaftar.";
    header('Location: ' . url_for('login'));
    exit();
}

require_once ROOT_PATH . 'app/models/Pendaftar.php';
require_once ROOT_PATH . 'app/models/Registration.php';

$user_id     = $_SESSION['user_id'];
$lowongan_id = filter_var($_POST['lowongan_id'] ?? null, FILTER_VALIDATE_INT);
$errors      = [];

/**
 * 1. SANITASI DATA & VALIDASI INPUT TEKS
 */

// Sanitasi Data Diri
$nama          = trim($_POST['nama'] ?? '');
$nik           = trim($_POST['NIK'] ?? '');
$jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
$tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
$alamat        = trim($_POST['alamat'] ?? '');
$nomor_hp      = trim($_POST['nomor_hp'] ?? '');
$email         = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);

// Sanitasi Data Pendidikan
$pendidikan = $_POST['pendidikan'] ?? '';
$instansi   = trim($_POST['instansi'] ?? '');
$prodi      = trim($_POST['prodi'] ?? '');
$jurusan    = trim($_POST['jurusan'] ?? '');
$semester   = trim($_POST['semester'] ?? '');
$ipk        = trim($_POST['ipk'] ?? null);

// Sanitasi Informasi Magang
$jabatan       = trim($_POST['jabatan'] ?? '');
$alasan_magang = trim($_POST['alasan'] ?? '');
$sumber_info   = $_POST['sumber'] ?? '';

// Validasi Aturan Bisnis (Mandatory Fields)
if (empty($nama) || empty($email) || empty($jabatan) || empty($nik)) {
    $errors[] = "Semua bidang wajib harus diisi (termasuk NIK).";
}
if (!preg_match('/^\d{16}$/', $nik)) {
    $errors[] = "NIK harus terdiri dari 16 digit angka.";
}
if (!$lowongan_id) {
    $errors[] = "ID Lowongan tidak ditemukan.";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Format email tidak valid.";
}

/**
 * 2. MANAJEMEN UNGGAH BERKAS (CV & PORTOFOLIO)
 */
$cv_path        = null;
$portfolio_path = null;
$upload_dir     = ROOT_PATH . 'public/uploads/'; 

if (empty($errors)) {
    // Memastikan direktori unggahan tersedia
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Pemrosesan unggah berkas CV (Wajib)
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
        $cv_ext  = pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION);
        $cv_name = "CV_" . $user_id . "_" . time() . "." . $cv_ext;
        if (move_uploaded_file($_FILES['cv']['tmp_name'], $upload_dir . $cv_name)) {
            $cv_path = 'uploads/' . $cv_name;
        } else {
            $errors[] = "Gagal memindahkan file CV.";
        }
    } else {
        $errors[] = "File CV wajib diunggah.";
    }

    // Pemrosesan unggah berkas Portofolio (Opsional)
    if (isset($_FILES['portofolio']) && $_FILES['portofolio']['error'] === UPLOAD_ERR_OK) {
        $port_ext  = pathinfo($_FILES['portofolio']['name'], PATHINFO_EXTENSION);
        $port_name = "PORT_" . $user_id . "_" . time() . "." . $port_ext;
        if (move_uploaded_file($_FILES['portofolio']['tmp_name'], $upload_dir . $port_name)) {
            $portfolio_path = 'uploads/' . $port_name;
        }
    }
}

/**
 * 3. PERSISTENSI DATA (DATABASE TRANSACTION)
 */
if (empty($errors)) {
    // Mapping data ke array asosiatif untuk layer Model
    $pendaftar_data = [
        'user_id'         => $user_id,
        'NIK'             => $nik,
        'nama'            => $nama,
        'jenis_kelamin'   => $jenis_kelamin, 
        'tanggal_lahir'   => $tanggal_lahir, 
        'alamat'          => $alamat, 
        'nomor_hp'        => $nomor_hp, 
        'email'           => $email, 
        'pendidikan'      => $pendidikan, 
        'instansi'        => $instansi, 
        'prodi'           => $prodi, 
        'jurusan'         => $jurusan, 
        'semester'        => $semester, 
        'ipk'             => $ipk, 
        'jabatan'         => $jabatan, 
        'alasan_magang'   => $alasan_magang, 
        'sumber_info'     => $sumber_info, 
        'cv_path'         => $cv_path, 
        'portofolio_path' => $portfolio_path
    ];

    try {
        /**
         * Menggunakan Database Transaction untuk menjamin integritas data (Atomicity).
         * Jika salah satu proses gagal, seluruh perubahan akan dibatalkan (Rollback).
         */
        $pdo->beginTransaction();

        // Operasi 1: Sinkronisasi profil lengkap pendaftar
        $profile_success = Pendaftar::updateFullProfile($pendaftar_data);

        // Operasi 2: Pencatatan aplikasi magang (Relasi User-Lowongan)
        $regis_success = Registration::createRegistration($user_id, $lowongan_id);

        if ($profile_success && $regis_success) {
            $pdo->commit();
            $_SESSION['success_message'] = "Pendaftaran magang berhasil!";
            header('Location: ' . url_for('halaman_utama'));
            exit();
        } else {
            throw new Exception("Gagal menyimpan data ke database.");
        }
    } catch (Exception $e) {
        // Pembatalan transaksi jika terjadi eksepsi
        $pdo->rollBack();
        $errors[] = "Detail Error: " . $e->getMessage();
    }
}

/**
 * 4. ERROR HANDLING & REDIRECT
 */
if (!empty($errors)) {
    // Menyimpan state error dan data lama (sticky form) ke dalam session
    $_SESSION['form_errors'] = $errors;
    $_SESSION['form_data']   = $_POST;
    header('Location: ' . url_for('pendaftaran') . '&lowongan_id=' . $lowongan_id);
    exit();
}