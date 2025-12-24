<?php
/**
 * Pendaftar.php
 * Model lengkap untuk mengelola data diri pendaftar.
 */

class Pendaftar {
    
    private static function getPdo() {
        global $pdo;
        return $pdo;
    }

    /**
     * SOLUSI ERROR Line 101: Digunakan saat registrasi akun baru
     */
    public static function createInitialProfile(array $data) {
        $pdo = self::getPdo();
        $sql = "INSERT INTO pendaftar (user_id, nama, email, created_at) 
                VALUES (:user_id, :nama, :email, NOW())";
        $stmt = $pdo->prepare($sql);
        try {
            return $stmt->execute([
                ':user_id' => $data['user_id'],
                ':nama'    => $data['nama'],
                ':email'   => $data['email']
            ]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * SOLUSI ERROR SEBELUMNYA: Digunakan untuk mengambil data di form
     */
    public static function getProfileByUserId($userId) {
        $pdo = self::getPdo();
        $sql = "SELECT * FROM pendaftar WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * FUNGSI UTAMA: Simpan/Update profil lengkap dari form pendaftaran
     */
    public static function updateFullProfile(array $data) {
        $pdo = self::getPdo();
        
        // Cek apakah data user sudah ada (Upsert Logic)
        $stmtCheck = $pdo->prepare("SELECT id FROM pendaftar WHERE user_id = ?");
        $stmtCheck->execute([$data['user_id']]);
        $exists = $stmtCheck->fetch();

        // Format IPK agar sesuai decimal database
        $ipk = !empty($data['ipk']) ? str_replace(',', '.', $data['ipk']) : 0.00;

        if ($exists) {
            $sql = "UPDATE pendaftar SET 
                        nama = :nama, email = :email, tanggal_lahir = :tanggal_lahir, 
                        jenis_kelamin = :jenis_kelamin, alamat = :alamat, nomor_hp = :nomor_hp, 
                        pendidikan = :pendidikan, instansi = :instansi, prodi = :prodi, 
                        jurusan = :jurusan, semester = :semester, ipk = :ipk, 
                        jabatan = :jabatan, alasan_magang = :alasan_magang, 
                        sumber_info = :sumber_info, cv_path = :cv_path, 
                        portofolio_path = :portofolio_path, NIK = :NIK,
                        updated_at = NOW() 
                    WHERE user_id = :user_id";
        } else {
            $sql = "INSERT INTO pendaftar (
                        user_id, nama, email, tanggal_lahir, jenis_kelamin, alamat, 
                        nomor_hp, pendidikan, instansi, prodi, jurusan, semester, 
                        ipk, jabatan, alasan_magang, sumber_info, cv_path, 
                        portofolio_path, NIK, created_at
                    ) VALUES (
                        :user_id, :nama, :email, :tanggal_lahir, :jenis_kelamin, :alamat, 
                        :nomor_hp, :pendidikan, :instansi, :prodi, :jurusan, :semester, 
                        :ipk, :jabatan, :alasan_magang, :sumber_info, :cv_path, 
                        :portofolio_path, :NIK, NOW()
                    )";
        }

        try {
            return $pdo->prepare($sql)->execute([
                ':user_id' => $data['user_id'],
                ':nama' => $data['nama'],
                ':email' => $data['email'],
                ':tanggal_lahir' => $data['tanggal_lahir'],
                ':jenis_kelamin' => $data['jenis_kelamin'],
                ':alamat' => $data['alamat'],
                ':nomor_hp' => $data['nomor_hp'],
                ':pendidikan' => $data['pendidikan'],
                ':instansi' => $data['instansi'],
                ':prodi' => $data['prodi'],
                ':jurusan' => $data['jurusan'],
                ':semester' => $data['semester'],
                ':ipk' => $ipk,
                ':jabatan' => $data['jabatan'],
                ':alasan_magang' => $data['alasan_magang'],
                ':sumber_info' => $data['sumber_info'],
                ':cv_path' => $data['cv_path'] ?? '', 
                ':portofolio_path' => $data['portofolio_path'] ?? '',
                ':NIK' => $data['NIK']
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}