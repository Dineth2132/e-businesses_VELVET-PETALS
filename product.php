<?php
require_once __DIR__ . '/includes/header.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    redirect('shop.php');
}

$stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    echo "<div class='container' style='padding: 4rem 0; text-align: center;'><h2>Product not found</h2><a href='shop.php'>Return to shop</a></div>";
    require_once __DIR__ . '/includes/footer.php';
    exit;
}
?>

<div class="container" style="padding: 4rem 0; min-height: 70vh;">
    <div style="display: flex; gap: 4rem; flex-wrap: wrap;">
        <!-- Image Gallery -->
        <div style="flex: 1; min-width: 300px;">
            <div style="width: 100%; aspect-ratio: 3/4; background-color: var(--color-accent); margin-bottom: 1rem;"></div>
        </div>
        
        <!-- Product Info -->
        <div style="flex: 1; min-width: 300px;">
            <p style="text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 0.5rem;"><?= e($product['category_name']) ?></p>
            <h1 style="font-size: 3rem; margin-bottom: 1rem;"><?= e($product['name']) ?></h1>
            <p style="font-size: 1.5rem; font-weight: 500; margin-bottom: 2rem;">Rs. <?= number_format($product['price'], 2) ?></p>
            
            <div style="margin-bottom: 2rem; line-height: 1.8; color: #444;">
                <?= nl2br(e($product['description'] ?? 'An elegant arrangement perfect for any occasion.')) ?>
            </div>
            
            <?php if ($product['is_available'] && $product['stock_quantity'] > 0): ?>
                <p style="color: #090; margin-bottom: 1.5rem;">✓ In Stock</p>
                <form action="cart.php" method="POST" style="display: flex; gap: 1rem; margin-bottom: 2rem;">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <div style="display: flex; align-items: center; border: 1px solid #ccc; padding: 0.5rem;">
                        <label for="qty" style="margin-right: 0.5rem;">Qty</label>
                        <input type="number" id="qty" name="quantity" value="1" min="1" max="<?= $product['stock_quantity'] ?>" style="width: 50px; border: none; text-align: center; font-family: var(--font-body);">
                    </div>
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Add to Bag</button>
                </form>
            <?php else: ?>
                <p style="color: #c00; font-weight: bold; margin-bottom: 1.5rem;">Out of Stock</p>
                <button class="btn btn-secondary" disabled style="width: 100%; opacity: 0.5; cursor: not-allowed;">Currently Unavailable</button>
            <?php endif; ?>
            
            <div style="border-top: 1px solid #eee; padding-top: 2rem; margin-top: 2rem;">
                <h4 style="font-family: var(--font-heading); margin-bottom: 1rem;">Delivery Information</h4>
                <p style="font-size: 0.9rem; color: #666;">We deliver fresh flowers carefully packaged to ensure they arrive in perfect condition. Same-day delivery available for orders placed before 2 PM.</p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
