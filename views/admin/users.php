
<?php
require_once ROOT_PATH . 'app/core/connection.php';


// PROSES TOGGLE STATUS
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['current_status'])) {
    $userId = $_POST['user_id'];
    $currentStatus = $_POST['current_status'];

    $newStatus = ($currentStatus === 'active') ? 'banned' : 'active';

    $stmt = $pdo->prepare("UPDATE users SET status = ? WHERE id = ?");
    $stmt->execute([$newStatus, $userId]);

    // refresh halaman biar status langsung berubah
    header("Location: index.php?page=admin_users");
    exit;
}

// ambil semua user yang role = user
$stmt = $pdo->prepare("SELECT id, name, email, status FROM users WHERE role = 'user'");
$stmt->execute();
$users = $stmt->fetchAll();
?>

<div class="admin-dashboard">
    <h1>Pengguna</h1>

    <div class="user-list">
        <?php if (empty($users)) : ?>
            <p>Tidak ada pengguna.</p>
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
                            <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
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

