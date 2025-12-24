<?php
/**
 * internship_update.php
 * Handler yang bertanggung jawab untuk memproses form pengubahan lowongan magang.
 */

global $is_logged_in, $user_role;

// 1. Pengecekan Akses dan Metode
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || ($user_role ?? 'guest') !== 'company') {
    header('Location: ' . url_for('halaman_utama'));
    exit();
}

// 2. Ambil ID Lowongan dari URL
$posting_id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
$company_id = $_SESSION['user_id'];
$company_name = $_SESSION['user_name']; 
$redirect_url = url_for('edit_internship') . '&id=' . $posting_id;

if (!$posting_id) {
    $_SESSION['internship_message'] = ['type' => 'error', 'text' => "ID Lowongan tidak valid."];
    header('Location: ' . url_for('company_dashboard'));
    exit();
}

// Cek kepemilikan sebelum memproses update
$existing_post = Internship::getPostingById($posting_id);
if (!$existing_post || $existing_post['company_id'] != $company_id) {
    $_SESSION['internship_message'] = ['type' => 'error', 'text' => "Akses ditolak: Lowongan tidak ditemukan atau bukan milik Anda."];
    header('Location: ' . url_for('company_dashboard'));
    exit();
}

// 3. Validasi dan Sanitasi Input
$data = $_POST;
$required_fields = ['posisi', 'deskripsi_pekerjaan', 'tanggal_mulai', 'tanggal_selesai'];
$errors = [];

foreach ($required_fields as $field) {
    if (empty($data[$field])) {
        $errors[] = "Kolom '{$field}' wajib diisi.";
    }
}

if (!empty($errors)) {
    $_SESSION['internship_message'] = ['type' => 'error', 'text' => implode('<br>', $errors)];
    $_SESSION['old_input'] = $data;
    header('Location: ' . $redirect_url);
    exit();
}

// 4. Penanganan Upload File Logo (Jika ada file baru, ganti yang lama)
$logo_url = $data['old_logo_url'] ?? 'img/default_logo.png'; // Default: Gunakan yang lama

if (isset($_FILES['logo_file']) && $_FILES['logo_file']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = ROOT_PATH . 'public/uploads/logos/';
    $file_info = pathinfo($_FILES['logo_file']['name']);
    $file_ext = strtolower($file_info['extension']);
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($file_ext, $allowed_ext)) {
        $file_name = $company_id . '_' . time() . '.' . $file_ext;
        $target_path = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['logo_file']['tmp_name'], $target_path)) {
            // Hapus file lama (Opsional, untuk menghemat ruang)
            $old_path = ROOT_PATH . 'public/' . $data['old_logo_url'];
            if (file_exists($old_path) && $data['old_logo_url'] !== 'img/default_logo.png') {
                unlink($old_path);
            }
            $logo_url = 'uploads/logos/' . $file_name; 
        } else {
            $errors[] = "Gagal memindahkan file logo baru.";
        }
    } else {
        $errors[] = "Jenis file logo baru tidak didukung.";
    }
}

if (!empty($errors)) {
    $_SESSION['internship_message'] = ['type' => 'error', 'text' => implode('<br>', $errors)];
    $_SESSION['old_input'] = $data;
    header('Location: ' . $redirect_url);
    exit();
}


// 5. Persiapan Data Akhir untuk Model Update
$final_data = [
    'posisi'                => $data['posisi'],
    'ringkasan'             => $data['ringkasan'] ?? null,
    'kualifikasi_jurusan'   => $data['kualifikasi_jurusan'] ?? null,
    'durasi'                => $data['durasi'] ?? null,
    'lokasi_penempatan'     => $data['lokasi_penempatan'] ?? null,
    'deskripsi_pekerjaan'   => $data['deskripsi_pekerjaan'],
    'requirements'          => $data['requirements'] ?? null,
    'tanggal_mulai'         => $data['tanggal_mulai'] . ' 00:00:00',
    'tanggal_selesai'       => $data['tanggal_selesai'] . ' 23:59:59',
    'website'               => $data['website'] ?? null,
    'instagram_link'        => $data['instagram_link'] ?? null,
    'logo_url'              => $logo_url, // URL logo yang sudah diperbarui/lama
];

// 6. Update ke Database
$success = Internship::updatePosting($posting_id, $final_data);

if ($success) {
    $_SESSION['internship_message'] = ['type' => 'success', 'text' => "Lowongan '{$final_data['posisi']}' berhasil diperbarui!"];
    // Redirect kembali ke dashboard perusahaan
    header('Location: ' . url_for('company_dashboard'));
    exit();
} else {
    // Penanganan error database
    $_SESSION['internship_message'] = ['type' => 'error', 'text' => "Gagal menyimpan perubahan lowongan ke database."];
    $_SESSION['old_input'] = $data;
    header('Location: ' . $redirect_url);
    exit();
}