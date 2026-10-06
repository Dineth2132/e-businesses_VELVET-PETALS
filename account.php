<?php
require_once __DIR__ . '/includes/header.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];
$success = $_GET['order_success'] ?? null;

// Fetch user orders
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();
?>

<div class="container" style="padding: 4rem 0; min-height: 70vh;">
    
    <?php if ($success): ?>
        <div style="background-color: #efe; color: #090; padding: 1.5rem; margin-bottom: 2rem; border: 1px solid #cfc; text-align: center;">
            <h2 style="font-family: var(--font-heading); margin-bottom: 0.5rem;">Thank You for Your Order!</h2>
            <p>Your order #<?= e($success) ?> has been placed successfully and is currently pending.</p>
        </div>
    <?php endif; ?>

    <div style="display: flex; gap: 4rem; flex-wrap: wrap;">
        <!-- Sidebar -->
        <aside style="width: 250px; flex-shrink: 0;">
            <h2 style="font-family: var(--font-heading); margin-bottom: 1.5rem;">My Account</h2>
            <ul style="list-style: none;">
                <li style="margin-bottom: 1rem;"><strong>Welcome, <?= e($_SESSION['full_name']) ?></strong></li>
                <li style="margin-bottom: 0.5rem;"><a href="account.php" style="color: var(--color-accent-dark);">Order History</a></li>
                <li style="margin-bottom: 0.5rem;"><a href="logout.php">Logout</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main style="flex: 1;">
            <h3 style="font-family: var(--font-heading); margin-bottom: 1.5rem; border-bottom: 1px solid #ddd; padding-bottom: 0.5rem;">Order History</h3>
            
            <?php if (count($orders) > 0): ?>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f9f9f9; text-align: left; border-bottom: 2px solid #ddd;">
                                <th style="padding: 1rem;">Order #</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr style="border-bottom: 1px solid #eee;">
                                    <td style="padding: 1rem;">#<?= e($order['id']) ?></td>
                                    <td><?= date('M j, Y', strtotime($order['created_at'])) ?></td>
                                    <td>Rs. <?= number_format($order['total_amount'], 2) ?></td>
                                    <td>
                                        <span style="padding: 0.2rem 0.5rem; border-radius: 3px; font-size: 0.85rem; 
                                            background-color: <?= $order['status'] === 'Delivered' ? '#efe' : ($order['status'] === 'Cancelled' ? '#fee' : '#eef8ff') ?>;
                                            color: <?= $order['status'] === 'Delivered' ? '#090' : ($order['status'] === 'Cancelled' ? '#c00' : '#0066cc') ?>;
                                        ">
                                            <?= e($order['status']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>You haven't placed any orders yet.</p>
                <a href="shop.php" class="btn btn-primary" style="margin-top: 1rem;">Start Shopping</a>
            <?php endif; ?>
        </main>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
