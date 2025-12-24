<?php
/**
 * User.php
 * Model ini menangani semua interaksi database untuk tabel 'users'.
 * Model ini sudah dimodifikasi untuk menangani kolom 'role'.
 */

// Pastikan koneksi database ($pdo) sudah tersedia di scope global
global $pdo; 

class User {
    
    /**
     * Mencari pengguna berdasarkan alamat email.
     * Digunakan selama proses login dan register (untuk cek duplikasi).
     * @param string $email
     * @return array|false Data pengguna (termasuk role) atau false jika tidak ditemukan.
     */
    public static function findByEmail($email) {
        global $pdo; // Akses koneksi database global

        // Kolom 'role' sudah disertakan dalam SELECT
        $sql = "SELECT id, name, email, password, role, status, created_at FROM users WHERE email = ?"; 
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /**
     * Membuat pengguna baru.
     * Digunakan selama proses registrasi.
     * @param array $data Array asosiatif berisi 'name', 'email', 'password', dan 'role'.
     * @return bool True jika berhasil, false jika gagal.
     */
    public static function create(array $data) {
        global $pdo;

        if (!isset($data['password'])) {
            return false;
        }
        
        // Pastikan role diset, default ke 'user'
        $role = $data['role'] ?? 'user'; 
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);

        // SQL diubah: Menambahkan kolom 'role'
        $sql = "INSERT INTO users (name, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())"; 
        $stmt = $pdo->prepare($sql);
        
        try {
            return $stmt->execute([
                $data['name'], 
                $data['email'], 
                $hashed_password,
                $role // <-- BINDING ROLE
            ]);
        } catch (\PDOException $e) {
            // Dalam kasus error database (misal: kolom role belum ada), ini akan mengembalikan false
            return false;
        }
    }

    /**
     * Memverifikasi kredensial pengguna.
     * @param string $email
     * @param string $password
     * @return array|false Data pengguna (termasuk role) jika kredensial valid, false jika gagal.
     */
    public static function verifyCredentials($email, $password) {
        // findByEmail sekarang akan mengembalikan data termasuk 'role'
        $user = self::findByEmail($email);

        if ($user) {
            // Membandingkan password yang di-hash dengan password yang dimasukkan
            if (password_verify($password, $user['password'])) {
                // Berhasil: Data user lengkap dikembalikan, siap disimpan ke sesi
                return $user;
            }
        }
        
        // Gagal
        return false;
    }
}