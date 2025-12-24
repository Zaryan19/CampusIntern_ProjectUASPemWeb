<?php
/**
 * Internship.php
 * Model untuk mengelola data lowongan magang (tabel lowongan_magang).
 */

class Internship {
    
    // Pastikan koneksi $pdo tersedia secara global (dari connection.php)
    private static function getPdo() {
        global $pdo;
        if (!isset($pdo)) {
            // Ini akan memastikan error ditangkap jika PDO belum terinisialisasi
            throw new Exception("Koneksi database (PDO) tidak tersedia.");
        }
        return $pdo;
    }

    /**
     * Mengambil semua lowongan magang, diurutkan berdasarkan tanggal terbaru.
     * @return array Array lowongan magang
     */

//  perusahaan banned → lowongan HILANG
// user tidak bisa lihat & daftar
// admin tetap bisa manage
    public static function getAllPostings() {
        $pdo = self::getPdo();

        $sql = "
            SELECT 
                lm.*
            FROM lowongan_magang lm
            JOIN users u ON lm.company_id = u.id
            WHERE u.role = 'company'
            AND u.status = 'active'
            ORDER BY lm.created_at DESC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // ADMIN ONLY
    public static function getAllPostingsForAdmin() {
        $pdo = self::getPdo();

        $sql = "
            SELECT 
                lm.*,
                u.status AS company_status
            FROM lowongan_magang lm
            JOIN users u ON lm.company_id = u.id
            WHERE u.role = 'company'
            ORDER BY lm.created_at DESC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    /**
     * Mengambil satu lowongan berdasarkan ID.
     * @param int $id ID Lowongan
     * @return array|false Data lowongan atau false jika tidak ditemukan
     */
    public static function getPostingById($id) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("SELECT * FROM lowongan_magang WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Mengambil lowongan magang berdasarkan ID Perusahaan.
     * @param int $companyId ID pengguna perusahaan yang sedang login
     * @return array Array lowongan magang milik perusahaan tersebut
     */
    public static function getPostingsByCompanyId($companyId) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("SELECT * FROM lowongan_magang WHERE company_id = :company_id ORDER BY created_at DESC");
        $stmt->execute([':company_id' => $companyId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Menyimpan lowongan magang baru.
     * @param array $data Data lowongan dari form
     * @return bool True jika berhasil, False jika gagal
     */
    public static function createPosting($data) {
        $pdo = self::getPdo();
        $sql = "INSERT INTO lowongan_magang (
                    company_id, perusahaan, posisi, ringkasan, kualifikasi_jurusan, 
                    durasi, lokasi_penempatan, deskripsi_pekerjaan, requirements, 
                    tanggal_mulai, tanggal_selesai, website, instagram_link, logo_url
                ) VALUES (
                    :company_id, :perusahaan, :posisi, :ringkasan, :kualifikasi_jurusan, 
                    :durasi, :lokasi_penempatan, :deskripsi_pekerjaan, :requirements, 
                    :tanggal_mulai, :tanggal_selesai, :website, :instagram_link, :logo_url
                )";
        
        $stmt = $pdo->prepare($sql);
        
        return $stmt->execute([
            ':company_id'           => $data['company_id'],
            ':perusahaan'           => $data['perusahaan'],
            ':posisi'               => $data['posisi'],
            ':ringkasan'            => $data['ringkasan'],
            ':kualifikasi_jurusan'  => $data['kualifikasi_jurusan'],
            ':durasi'               => $data['durasi'],
            ':lokasi_penempatan'    => $data['lokasi_penempatan'],
            ':deskripsi_pekerjaan'  => $data['deskripsi_pekerjaan'],
            ':requirements'         => $data['requirements'],
            ':tanggal_mulai'        => $data['tanggal_mulai'],
            ':tanggal_selesai'      => $data['tanggal_selesai'],
            ':website'              => $data['website'],
            ':instagram_link'       => $data['instagram_link'],
            ':logo_url'             => $data['logo_url'],
        ]);
    }

    /**
     * Mengubah data lowongan magang yang sudah ada.
     * @param int $id ID Lowongan yang akan diubah
     * @param array $data Data lowongan baru dari form
     * @return bool True jika berhasil, False jika gagal
     */
    public static function updatePosting($id, $data) {
        $pdo = self::getPdo();
        
        // Perusahaan dan company_id tidak perlu di-update kecuali jika ada migrasi akun
        $sql = "UPDATE lowongan_magang SET
                    posisi = :posisi,
                    ringkasan = :ringkasan,
                    kualifikasi_jurusan = :kualifikasi_jurusan, 
                    durasi = :durasi, 
                    lokasi_penempatan = :lokasi_penempatan, 
                    deskripsi_pekerjaan = :deskripsi_pekerjaan, 
                    requirements = :requirements, 
                    tanggal_mulai = :tanggal_mulai, 
                    tanggal_selesai = :tanggal_selesai, 
                    website = :website, 
                    instagram_link = :instagram_link, 
                    logo_url = :logo_url
                WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        
        return $stmt->execute([
            ':id'                   => $id,
            ':posisi'               => $data['posisi'],
            ':ringkasan'            => $data['ringkasan'],
            ':kualifikasi_jurusan'  => $data['kualifikasi_jurusan'],
            ':durasi'               => $data['durasi'],
            ':lokasi_penempatan'    => $data['lokasi_penempatan'],
            ':deskripsi_pekerjaan'  => $data['deskripsi_pekerjaan'],
            ':requirements'         => $data['requirements'],
            ':tanggal_mulai'        => $data['tanggal_mulai'],
            ':tanggal_selesai'      => $data['tanggal_selesai'],
            ':website'              => $data['website'] ?? null,
            ':instagram_link'       => $data['instagram_link'] ?? null,
            ':logo_url'             => $data['logo_url'] ?? 'default/logo.png', // Pastikan logo_url di handle di handler
        ]);
    }

    /**
     * Menghapus lowongan berdasarkan ID.
     * @param int $id ID Lowongan
     * @return bool True jika berhasil, False jika gagal
     */
    public static function deletePosting($id) {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare("DELETE FROM lowongan_magang WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}