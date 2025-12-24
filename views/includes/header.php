<?php
/**
 * header.php
 * File ini berisi tag <head>, CSS, dan Navbar.
 * ...
 */

// Pastikan variabel global sudah tersedia (ini penting)
global $is_logged_in, $user_name, $user_role;
$page_title = $page_title ?? "Halaman Utama"; 
$is_dark_mode = $_COOKIE['theme'] ?? 'light'; 

?>

<!DOCTYPE html>
<html lang="id" class="<?= $is_dark_mode === 'dark' ? 'dark' : '' ?>">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CampusIntern | <?= htmlspecialchars($page_title) ?></title>
    
    <!-- CSS Kustom: HARUS JALUR RELATIF DARI PUBLIC/ -->
    <link rel="stylesheet" href="css/style.css">
    
    <!-- Feather Icons (untuk tombol) -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="main-body">
    
    <nav class="navbar">
        <div class="nav-brand">
            CampusIntern 
            <?php if ($is_logged_in): ?>
                <span class="auth-welcome">| Welcome, <?= htmlspecialchars($user_name) ?> (<?= ucfirst($user_role) ?>)</span>
            <?php endif; ?>
        </div>

        <div class="nav-wrapper">
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="<?= url_for('halaman_utama') ?>" class="nav-link nav-feature-button">Beranda</a>
                </li>
                <li class="nav-item">
                    <a href="<?= url_for('info') ?>" class="nav-link nav-feature-button">Informasi</a>
                </li>
                
                <?php if ($user_role === 'company'): ?>
                    <li class="nav-item">
                        <a href="<?= url_for('company_dashboard') ?>" class="nav-link nav-feature-button">Dashboard Perusahaan</a>
                    </li>
                <?php endif; ?>

                <?php if ($user_role === 'admin'): ?>
                    <li class="nav-item">
                        <a href="<?= url_for('admin_dashboard') ?>" class="nav-link nav-feature-button">Dashboard Admin</a>
                    </li>
                <?php endif; ?>

                </ul>
            
            <div class="nav-actions">
                <?php if ($is_logged_in): ?>
                    <a href="index.php?action=logout" class="buttonlogout">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="<?= url_for('login') ?>" class="buttonlogin">Login</a>
                <?php endif; ?>

                <button id="darkModeToggle" class="dark-mode-toggle theme-toggle">
                    </button>
            </div>
        </div>
    </nav>
    <main class="page-content">