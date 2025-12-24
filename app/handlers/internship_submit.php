<?php
/**
 * internship_submit.php
 * Handler yang bertanggung jawab untuk memproses form penambahan lowongan magang.
 */

// Pastikan hanya bisa diakses via POST dan hanya oleh Perusahaan
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || ($user_role ?? 'guest') !== 'company') {
    header('Location: ' . url_for('halaman_utama'));
    exit();
}

// 1. Ambil data dari POST
$data = $_POST;
$company_id = $_SESSION['user_id'];
$company_name = $_SESSION['user_name']; // Menggunakan nama perusahaan yang login

// 2. Validasi Input Kritis
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
    header('Location: ' . url_for('add_internship'));
    exit();
}

// 3. Penanganan Upload File Logo
$logo_url = null;
if (isset($_FILES['logo_file']) && $_FILES['logo_file']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = ROOT_PATH . 'public/uploads/logos/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_info = pathinfo($_FILES['logo_file']['name']);
    $file_ext = strtolower($file_info['extension']);
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($file_ext, $allowed_ext)) {
        // Buat nama file unik: companyID_timestamp.ext
        $file_name = $company_id . '_' . time() . '.' . $file_ext;
        $target_path = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['logo_file']['tmp_name'], $target_path)) {
            // Path yang disimpan di database adalah path relatif dari public/
            $logo_url = 'uploads/logos/' . $file_name; 
        } else {
            $errors[] = "Gagal memindahkan file logo.";
        }
    } else {
        $errors[] = "Jenis file logo tidak didukung.";
    }
}

if (!empty($errors)) {
    $_SESSION['internship_message'] = ['type' => 'error', 'text' => implode('<br>', $errors)];
    $_SESSION['old_input'] = $data;
    header('Location: ' . url_for('add_internship'));
    exit();
}

// 4. Persiapan Data Akhir untuk Model
$final_data = [
    'company_id'            => $company_id,
    'perusahaan'            => $company_name, // Mengambil dari sesi
    'posisi'                => $data['posisi'],
    'ringkasan'             => $data['ringkasan'] ?? null,
    'kualifikasi_jurusan'   => $data['kualifikasi_jurusan'] ?? null,
    'durasi'                => $data['durasi'] ?? null,
    'lokasi_penempatan'     => $data['lokasi_penempatan'] ?? null,
    'deskripsi_pekerjaan'   => $data['deskripsi_pekerjaan'],
    'requirements'          => $data['requirements'] ?? null,
    'tanggal_mulai'         => $data['tanggal_mulai'] . ' 00:00:00', // Tambah waktu
    'tanggal_selesai'       => $data['tanggal_selesai'] . ' 23:59:59', // Tambah waktu
    'website'               => $data['website'] ?? null,
    'instagram_link'        => $data['instagram_link'] ?? null,
    'logo_url'              => $logo_url ?? 'img/default_logo.png', // Default jika tidak ada upload
];


// 5. Simpan ke Database
$success = Internship::createPosting($final_data);

if ($success) {
    $_SESSION['internship_message'] = ['type' => 'success', 'text' => "Lowongan magang '{$final_data['posisi']}' berhasil diposting!"];
    // Redirect ke halaman informasi (info.php) atau dashboard perusahaan
    header('Location: ' . url_for('info'));
    exit();
} else {
    // Penanganan error database
    $_SESSION['internship_message'] = ['type' => 'error', 'text' => "Gagal menyimpan lowongan ke database. Coba lagi."];
    $_SESSION['old_input'] = $data;
    header('Location: ' . url_for('add_internship'));
    exit();
}