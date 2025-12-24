<?php
require_once ROOT_PATH . 'app/core/connection.php';

// ===============================
// PROSES TOGGLE STATUS
// ===============================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['company_id'], $_POST['current_status'])) {
    $companyId = $_POST['company_id'];
    $currentStatus = $_POST['current_status'];

    $newStatus = ($currentStatus === 'active') ? 'banned' : 'active';

    $stmt = $pdo->prepare("UPDATE users SET status = ? WHERE id = ?");
    $stmt->execute([$newStatus, $companyId]);

    // refresh halaman
    header("Location: index.php?page=admin_company");
    exit;
}

// ===============================
// AMBIL SEMUA PERUSAHAAN
// ===============================
$stmt = $pdo->prepare("SELECT id, name, email, status FROM users WHERE role = 'company'");
$stmt->execute();
$users = $stmt->fetchAll();
?>

<div class="admin-dashboard">
    <h1>Perusahaan</h1>

    <div class="user-list">
        <?php if (empty($users)) : ?>
            <p>Tidak ada perusahaan.</p>
        <?php else : ?>
            <?php foreach ($users as $user) : ?>
                <div class="user-card">
                    <div class="user-info">
                        <strong class="user-name">
                            <?= htmlspecialchars($user['name']) ?>
                        </strong>
                        <span class="user-email">
                            <?= htmlspecialchars($user['email']) ?>
                        </span>
                    </div>

                    <div class="user-actions">
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="company_id" value="<?= $user['id']; ?>">
                            <input type="hidden" name="current_status" value="<?= $user['status']; ?>">

                            <?php if ($user['status'] === 'active') : ?>
                                <button type="submit" class="badge-user active">
                                    Active
                                </button>
                            <?php else : ?>
                                <button type="submit" class="badge-user banned">
                                    Banned
                                </button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
