<?php
require_once __DIR__ . '/includes/header.php';

if (!is_logged_in()) {
    // For this project, we require login to use the cart (to easily use DB cart table)
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];
$message = '';

// Handle cart actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'] ?? 1;
        
        $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)");
        $stmt->execute([$user_id, $product_id, $quantity]);
        
        redirect('cart.php');
    } elseif ($action === 'update') {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        
        if ($quantity > 0) {
            $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
            $stmt->execute([$quantity, $user_id, $product_id]);
        } else {
            $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
            $stmt->execute([$user_id, $product_id]);
        }
        redirect('cart.php');
    } elseif ($action === 'remove') {
        $product_id = $_POST['product_id'];
        $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
        redirect('cart.php');
    }
}

// Fetch cart items
$stmt = $pdo->prepare("SELECT c.*, p.name, p.price, p.image_url, p.stock_quantity FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll();

$subtotal = 0;
?>

<div class="container" style="padding: 4rem 0; min-height: 70vh;">
    <h1 style="text-align: center; margin-bottom: 3rem;">Your Shopping Bag</h1>
    
    <?php if (count($cart_items) > 0): ?>
        <div style="display: flex; gap: 4rem; flex-wrap: wrap;">
            
            <div style="flex: 2; min-width: 300px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #ddd; text-align: left;">
                            <th style="padding: 1rem 0;">Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): 
                            $item_total = $item['price'] * $item['quantity'];
                            $subtotal += $item_total;
                        ?>
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 1.5rem 0; display: flex; gap: 1rem; align-items: center;">
                                    <div style="width: 80px; height: 100px; background-color: var(--color-accent);"></div>
                                    <a href="product.php?id=<?= $item['product_id'] ?>" style="font-family: var(--font-heading); font-size: 1.2rem;"><?= e($item['name']) ?></a>
                                </td>
                                <td>Rs. <?= number_format($item['price'], 2) ?></td>
                                <td>
                                    <form action="cart.php" method="POST" style="display: flex; gap: 0.5rem;">
                                        <input type="hidden" name="action" value="update">
                                        <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock_quantity'] ?>" style="width: 50px; padding: 0.2rem; text-align: center;">
                                        <button type="submit" style="background: none; border: none; cursor: pointer; text-decoration: underline; color: #666; font-size: 0.8rem;">Update</button>
                                    </form>
                                </td>
                                <td>Rs. <?= number_format($item_total, 2) ?></td>
                                <td>
                                    <form action="cart.php" method="POST">
                                        <input type="hidden" name="action" value="remove">
                                        <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                        <button type="submit" style="background: none; border: none; cursor: pointer; color: #c00;">✕</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div style="flex: 1; min-width: 300px; background-color: #fcfcfc; padding: 2rem; border: 1px solid #eee;">
                <h3 style="font-family: var(--font-heading); margin-bottom: 1.5rem; border-bottom: 1px solid #ddd; padding-bottom: 1rem;">Order Summary</h3>
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                    <span>Subtotal</span>
                    <span>Rs. <?= number_format($subtotal, 2) ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                    <span>Delivery</span>
                    <span>Calculated at checkout</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.2rem; border-top: 1px solid #ddd; padding-top: 1rem; margin-top: 1rem; margin-bottom: 2rem;">
                    <span>Estimated Total</span>
                    <span>Rs. <?= number_format($subtotal, 2) ?></span>
                </div>
                <a href="checkout.php" class="btn btn-primary" style="width: 100%; text-align: center;">Proceed to Checkout</a>
                <a href="shop.php" style="display: block; text-align: center; margin-top: 1rem; text-decoration: underline; font-size: 0.9rem;">Continue Shopping</a>
            </div>
            
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 4rem 0;">
            <p style="font-size: 1.2rem; margin-bottom: 2rem;">Your bag is currently empty.</p>
            <a href="shop.php" class="btn btn-primary">Start Shopping</a>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
