<?php
/**
 * Registration.php
 * Model untuk mengelola data Log Aplikasi / Pendaftaran Magang (tabel 'pendaftaran').
 */

class Registration {
    
    private static function getPdo() {
        global $pdo;
        if (!isset($pdo)) {
            throw new Exception("Koneksi database (PDO) tidak tersedia.");
        }
        return $pdo;
    }

    /**
     * Memeriksa apakah pengguna sudah terdaftar di lowongan tertentu.
     */
    public static function hasRegistered($userId, $lowonganId) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM pendaftaran WHERE user_id = :user_id AND lowongan_id = :lowongan_id");
        $stmt->execute([
            ':user_id' => $userId,
            ':lowongan_id' => $lowonganId
        ]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Mencatat log pendaftaran baru ke tabel 'pendaftaran'.
     * @param int $userId ID pengguna yang mendaftar
     * @param int $lowonganId ID lowongan yang didaftar
     * @return bool True jika berhasil, False jika gagal atau sudah terdaftar.
     */
    public static function createRegistration($userId, $lowonganId) {
        $pdo = self::getPdo();
        
        // Cek duplikasi sebelum INSERT
        if (self::hasRegistered($userId, $lowonganId)) {
            return false; // User sudah pernah mendaftar lowongan ini
        }
        
        // Asumsi: Tabel Anda bernama 'pendaftaran' dan memiliki kolom user_id, lowongan_id, status, tanggal_daftar
        $sql = "INSERT INTO pendaftaran (user_id, lowongan_id, status, tanggal_daftar) 
                VALUES (:user_id, :lowongan_id, 'Pending', NOW())";
        
        $stmt = $pdo->prepare($sql);
        
        try {
            return $stmt->execute([
                ':user_id' => $userId,
                ':lowongan_id' => $lowonganId
            ]);
        } catch (\PDOException $e) {
            // Log error atau kembalikan false
            return false;
        }
    }
}