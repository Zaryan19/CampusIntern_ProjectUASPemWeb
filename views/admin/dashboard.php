<?php
// Pastikan koneksi $pdo sudah ada dari index.php / connection.php

// Jumlah pengguna (role = user)
$stmtUser = $pdo->prepare("SELECT COUNT(*) FROM users WHERE role = 'user'");
$stmtUser->execute();
$totalUser = $stmtUser->fetchColumn();

// Jumlah perusahaan (role = company)
$stmtCompany = $pdo->prepare("SELECT COUNT(*) FROM users WHERE role = 'company'");
$stmtCompany->execute();
$totalCompany = $stmtCompany->fetchColumn();

// Jumlah lowongan magang (sesuaikan nama tabel!)
$totalLowongan = $pdo
    ->query("SELECT COUNT(*) FROM lowongan_magang") // atau nama tabel kamu
    ->fetchColumn();
?>

<div class="admin-dashboard">
    <h1>Dashboard</h1>

    <div class="admin-stats">
        <a href="index.php?page=admin_users" class="admin-card link-card">
            <h2><?= $totalUser ?></h2>
            <p>Pengguna</p>
        </a>

        <a href="index.php?page=admin_company" class="admin-card link-card">
            <h2><?= $totalCompany ?></h2>
            <p>Perusahaan</p>
        </a>

        <a href="index.php?page=admin_lowongan" class="admin-card link-card">
            <h2><?= $totalLowongan ?></h2>
            <p>Lowongan Magang</p>
        </a>
    </div>
</div>



