<?php

/**
 * 1. KONFIGURASI KREDENSIAL DATABASE
 * Mengatur parameter koneksi ke database MySQL.
 */
$host    = '127.0.0.1'; 
$db      = 'uaswebbb'; 
$user    = 'root'; 
$pass    = 'ZARY666AN'; 
$charset = 'utf8mb4'; 

/**
 * 2. KONSTRUKSI DSN & OPSI PDO
 * DSN (Data Source Name) mendefinisikan driver, host, dan nama database.
 */
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    // Mengaktifkan mode error Exception untuk penanganan error yang lebih baik
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    
    // Mengatur hasil query default sebagai array asosiatif
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    
    // Keamanan: Menonaktifkan emulasi prepared statements untuk mencegah SQL Injection
    PDO::ATTR_EMULATE_PREPARES   => false,
];

/**
 * 3. INISIALISASI KONEKSI (DATABASE CONNECTION)
 * Membuat instance PDO global yang akan digunakan di seluruh modul aplikasi.
 */
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // Menghentikan skrip dan menampilkan pesan jika koneksi database gagal
     die("Koneksi database gagal: " . $e->getMessage());
}