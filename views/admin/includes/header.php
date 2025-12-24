<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CampusIntern | Admin Panel</title>
    <link rel="stylesheet" href="css/style.css">

    
</head>
<body>

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
                <a href="index.php?page=admin_dashboard" class="nav-link nav-feature-button">Dashboard</a>
            </li>
            <div class="nav-actions">
                <?php if ($is_logged_in): ?>
                    <a href="index.php?action=logout" class="buttonlogout">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="<?= url_for('login') ?>" class="buttonlogin">Login</a>
                <?php endif; ?>
            </div>
    </div>


</nav>
