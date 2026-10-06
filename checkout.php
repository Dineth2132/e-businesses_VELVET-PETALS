<?php
require_once __DIR__ . '/includes/header.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];

// Fetch cart items
$stmt = $pdo->prepare("SELECT c.*, p.name, p.price, p.stock_quantity FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll();

if (count($cart_items) === 0) {
    redirect('cart.php');
}

$subtotal = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$delivery_fee = 15.00; // Flat rate for demo
$total = $subtotal + $delivery_fee;

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delivery_name = trim($_POST['delivery_name'] ?? '');
    $delivery_phone = trim($_POST['delivery_phone'] ?? '');
    $delivery_address = trim($_POST['delivery_address'] ?? '');
    $delivery_city = trim($_POST['delivery_city'] ?? '');
    $delivery_notes = trim($_POST['delivery_notes'] ?? '');
    $payment_method = trim($_POST['payment_method'] ?? 'Cash on Delivery');
    
    if (empty($delivery_name) || empty($delivery_phone) || empty($delivery_address) || empty($delivery_city) || empty($payment_method)) {
        $error = 'Please fill in all required fields, including payment method.';
    } else {
        try {
            $pdo->beginTransaction();
            
            // Create Order
            $stmt = $pdo->prepare("INSERT INTO orders (user_id, subtotal, delivery_fee, total_amount, status, delivery_name, delivery_phone, delivery_address, delivery_city, delivery_notes, payment_method) VALUES (?, ?, ?, ?, 'Pending', ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $subtotal, $delivery_fee, $total, $delivery_name, $delivery_phone, $delivery_address, $delivery_city, $delivery_notes, $payment_method]);
            $order_id = $pdo->lastInsertId();
            
            // Insert Order Items and update stock
            $item_stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_at_time) VALUES (?, ?, ?, ?)");
            $stock_stmt = $pdo->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?");
            
            foreach ($cart_items as $item) {
                $item_stmt->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);
                $stock_stmt->execute([$item['quantity'], $item['product_id']]);
            }
            
            // Clear Cart
            $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
            $stmt->execute([$user_id]);
            
            $pdo->commit();
            
            // Redirect based on payment method
            if ($payment_method !== 'Cash on Delivery') {
                redirect("payhere.php?order_id=$order_id");
            } else {
                redirect("account.php?order_success=$order_id");
            }
            
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = 'There was an error processing your order. Please try again.';
        }
    }
}
?>

<div class="container" style="padding: 4rem 0;">
    <h1 style="text-align: center; margin-bottom: 3rem;">Checkout</h1>
    
    <?php if ($error): ?>
        <div style="background-color: #fee; color: #c00; padding: 1rem; margin-bottom: 1.5rem; text-align: center; border: 1px solid #fcc;">
            <?= e($error) ?>
        </div>
    <?php endif; ?>
    
    <div style="display: flex; gap: 4rem; flex-wrap: wrap; flex-direction: row-reverse;">
        
        <!-- Order Summary -->
        <div style="flex: 1; min-width: 300px; background-color: #fcfcfc; padding: 2rem; border: 1px solid #eee; height: fit-content;">
            <h3 style="font-family: var(--font-heading); margin-bottom: 1.5rem; border-bottom: 1px solid #ddd; padding-bottom: 1rem;">Order Summary</h3>
            
            <div style="margin-bottom: 1.5rem;">
                <?php foreach ($cart_items as $item): ?>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.9rem;">
                        <span><?= e($item['quantity']) ?>x <?= e($item['name']) ?></span>
                        <span>Rs. <?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; border-top: 1px solid #ddd; padding-top: 1rem;">
                <span>Subtotal</span>
                <span>Rs. <?= number_format($subtotal, 2) ?></span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                <span>Delivery</span>
                <span>Rs. <?= number_format($delivery_fee, 2) ?></span>
            </div>
            <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.2rem; border-top: 1px solid #ddd; padding-top: 1rem; margin-top: 1rem;">
                <span>Total</span>
                <span>Rs. <?= number_format($total, 2) ?></span>
            </div>
        </div>
        
        <!-- Delivery Form -->
        <div style="flex: 2; min-width: 300px;">
            <form action="checkout.php" method="POST">
                <h3 style="font-family: var(--font-heading); margin-bottom: 1.5rem;">Delivery Information</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="delivery_name">Recipient Full Name *</label>
                        <input type="text" id="delivery_name" name="delivery_name" required value="<?= e($_SESSION['full_name']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="delivery_phone">Recipient Phone *</label>
                        <input type="text" id="delivery_phone" name="delivery_phone" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="delivery_address">Street Address *</label>
                    <input type="text" id="delivery_address" name="delivery_address" required>
                </div>
                
                <div class="form-group">
                    <label for="delivery_city">City *</label>
                    <input type="text" id="delivery_city" name="delivery_city" required>
                </div>
                
                <div class="form-group">
                    <label for="delivery_notes">Delivery Notes (Optional)</label>
                    <textarea id="delivery_notes" name="delivery_notes" rows="3"></textarea>
                </div>
                
                <div style="margin-top: 2rem;">
                    <h3 style="font-family: var(--font-heading); margin-bottom: 1.5rem;">Payment Method</h3>
                    <div style="padding: 1.5rem; background-color: #f9f9f9; border: 1px solid #eaeaea; border-radius: 8px; margin-bottom: 2rem; display: flex; flex-direction: column; gap: 15px;">
                        <label style="display: flex; align-items: center; cursor: pointer; padding: 10px; border: 1px solid #ddd; border-radius: 6px; background: white; transition: all 0.2s;">
                            <input type="radio" name="payment_method" value="Cash on Delivery" checked style="margin-right: 15px; transform: scale(1.2);">
                            <div>
                                <div style="font-weight: 600; font-size: 1.05rem;">Cash on Delivery (COD)</div>
                                <div style="font-size: 0.85rem; color: #666;">Pay with cash upon delivery.</div>
                            </div>
                        </label>
                        <label style="display: flex; align-items: center; cursor: pointer; padding: 10px; border: 1px solid #ddd; border-radius: 6px; background: white; transition: all 0.2s;">
                            <input type="radio" name="payment_method" value="Card Payment" style="margin-right: 15px; transform: scale(1.2);">
                            <div>
                                <div style="font-weight: 600; font-size: 1.05rem;">Card Payment <i class="fas fa-credit-card" style="color: var(--vp-burgundy); margin-left: 5px;"></i></div>
                                <div style="font-size: 0.85rem; color: #666;">Pay securely with Visa or Mastercard.</div>
                            </div>
                        </label>
                        <label style="display: flex; align-items: center; cursor: pointer; padding: 10px; border: 1px solid #ddd; border-radius: 6px; background: white; transition: all 0.2s;">
                            <input type="radio" name="payment_method" value="Online Banking Payment" style="margin-right: 15px; transform: scale(1.2);">
                            <div>
                                <div style="font-weight: 600; font-size: 1.05rem;">Online Banking Payment <i class="fas fa-university" style="color: var(--vp-burgundy); margin-left: 5px;"></i></div>
                                <div style="font-size: 0.85rem; color: #666;">Transfer directly from your bank account.</div>
                            </div>
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1.1rem; padding: 1rem;">Place Order</button>
            </form>
        </div>
        
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
