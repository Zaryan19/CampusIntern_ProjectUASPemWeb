<?php
/**
 * home.php (views/pages/info.php)
 * Konten utama untuk halaman Beranda/Informasi Lowongan.
 */
global $is_logged_in, $user_role;

// --- PERBAIKAN 1: Pastikan Model dimuat di sini jika tidak dimuat secara global ---
// Ini penting agar Internship::getAllPostings() bisa dipanggil
// require_once ROOT_PATH . 'app/models/Internship.php'; // Hapus jika sudah dimuat di index.php

// Set judul halaman untuk header.php
$page_title = "Informasi"; 
$lowongan_list = Internship::getAllPostings();

// --- Perhatikan: Navbar sudah ada di header.php, jadi konten dimulai setelah <nav> --- 
?>

    <div class="info-page-container">
    

    <h1 class="page-title">Daftar Lowongan Magang</h1>

    <div class="grid-container">
        <?php if (empty($lowongan_list)): ?>
            <p>Saat ini belum ada lowongan magang yang tersedia.</p>
        <?php else: ?>
            
            <?php foreach ($lowongan_list as $post): ?>
            <div class="card">
                
                <img class="gambarcard" src="<?= htmlspecialchars($post['logo_url']) ?>" alt="Logo <?= htmlspecialchars($post['perusahaan']) ?>" />

                <h2 class="h2"><?= htmlspecialchars($post['posisi']) ?> | <?= htmlspecialchars($post['perusahaan']) ?></h2>
                <h4 class="h4">
                    <?= htmlspecialchars($post['kualifikasi_jurusan']) ?>
                </h4>
                <p class="deskripsicard">
                    <?= htmlspecialchars($post['ringkasan']) ?>
                </p>
                
                <div class="card-hidden">
                    <div class="card-header">
                        <div class="card-title">Selengkapnya</div>
                        <div class="toggle-icon">▼</div>
                    </div>
                    <div class="card-content">
                        <p class="description-short">Durasi magang : <?= htmlspecialchars($post['durasi']) ?>.</p>
                        <p class="description-short">Penempatan : <?= htmlspecialchars($post['lokasi_penempatan']) ?>.</p>
                        <div class="description-long">
                            <p class="deskripsicardisi">
                                <?= nl2br(htmlspecialchars($post['deskripsi_pekerjaan'])) ?>
                            </p>
                            
                            <p class="deskripsicardisi"><strong>Kualifikasi/Persyaratan:</strong></p>
                            <ul class="deskripsicardisi">
                                <li><?= nl2br(htmlspecialchars($post['requirements'])) ?></li>
                            </ul>
                            
                            <div class="highlight">
                                <strong>Pendaftaran : </strong><?= date('d M Y', strtotime($post['tanggal_mulai'])) ?> - <?= date('d M Y', strtotime($post['tanggal_selesai'])) ?>.
                            </div>
                            
                            <div class="button-container">
                                <?php if (!empty($post['website'])): ?>
                                <a href="<?= htmlspecialchars($post['website']) ?>" target="_blank" class="btn btn-website">
                                    <i data-feather="globe"></i> Website
                                </a>
                                <?php endif; ?>
                                <?php if (!empty($post['instagram_link'])): ?>
                                <a href="<?= htmlspecialchars($post['instagram_link']) ?>" target="_blank" class="btn btn-instagram">
                                    <i data-feather="instagram"></i> Instagram
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-actions"> <?php if ($user_role === 'user' && $is_logged_in): ?>
                        <button
                            class="btn-daftar"
                            onclick="window.location.href='<?= url_for('pendaftaran') . '&lowongan_id=' . $post['id'] ?>'"
                        >
                            Daftar Lowongan
                        </button>
                    <?php elseif ($user_role === 'company' && $is_logged_in): ?>
                        <a 
                            href="<?= url_for('edit_internship') . '&id=' . $post['id'] ?>" 
                            class="btn-edit" 
                        >
                            Edit Lowongan
                        </a>
                    <?php else: ?>
                        <a href="<?= url_for('login') ?>" class="btn-daftar" style="background-color: #8e877fff;">
                            Login untuk Mendaftar
                        </a>
                    <?php endif; ?>
                </div> </div> <?php endforeach; ?>
            
        <?php endif; ?>
    </div> </div>