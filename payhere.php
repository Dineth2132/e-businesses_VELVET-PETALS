<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$order_id = $_GET['order_id'] ?? 0;
if (!$order_id) {
    redirect('index.php');
}

// Fetch order details
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->execute([$order_id, $_SESSION['user_id']]);
$order = $stmt->fetch();

if (!$order || $order['status'] !== 'Pending') {
    redirect('account.php');
}

// Fetch user details
$stmt_user = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt_user->execute([$_SESSION['user_id']]);
$user = $stmt_user->fetch();

$merchant_id = "1238342";
$merchant_secret = "NDIxNDEyMTkzMjQwMzI1MTA4NDAyNzM1MDUwNjUxMjUzNjExNzg1MQ==";
$currency = "LKR";
$amount = number_format($order['total_amount'], 2, '.', '');
$order_id_str = strval($order['id']);

$hash = strtoupper(
    md5(
        $merchant_id . 
        $order_id_str . 
        $amount . 
        $currency .  
        strtoupper(md5($merchant_secret)) 
    ) 
);

$return_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/account.php?order_success=" . $order['id'];
$cancel_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/checkout.php";
$notify_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/payhere_notify.php";

$first_name = "Customer";
$last_name = "";
if (strpos($user['full_name'], ' ') !== false) {
    $parts = explode(' ', $user['full_name'], 2);
    $first_name = $parts[0];
    $last_name = $parts[1];
} else {
    $first_name = $user['full_name'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Secure Payment</title>
    <style>
        body { font-family: 'Outfit', sans-serif; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; margin: 0; background-color: #FDFBF7; }
        .vp-card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center; border: 1px solid #eaeaea; max-width: 500px; width: 90%; }
        .btn { padding: 12px 30px; background-color: #5B2333; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 1.1rem; font-family: 'Outfit', sans-serif; margin-top: 20px; transition: background 0.2s; }
        .btn:hover { background-color: #3A1520; }
    </style>
    <!-- PayHere JavaScript SDK -->
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
</head>
<body>
    <div class="vp-card">
        <i class="fas fa-lock" style="font-size: 3rem; color: #5B2333; margin-bottom: 20px;"></i>
        <h2 style="color: #5B2333; margin-bottom: 10px;">Secure Checkout</h2>
        <p style="color: #666; margin-bottom: 20px;">Order Total: Rs. <?= $amount ?></p>
        
        <button id="payhere-payment" class="btn">Pay Now with PayHere</button>
    </div>

    <script>
        // PayHere Payment Configuration
        var payment = {
            "sandbox": true,
            "merchant_id": "<?= $merchant_id ?>", 
            "return_url": "<?= $return_url ?>",
            "cancel_url": "<?= $cancel_url ?>",
            "notify_url": "<?= $notify_url ?>",
            "order_id": "<?= $order_id_str ?>",
            "items": "Velvet Petals Order #<?= $order_id_str ?>",
            "amount": "<?= $amount ?>",
            "currency": "<?= $currency ?>",
            "hash": "<?= $hash ?>",
            "first_name": "<?= e($first_name ?? 'Customer') ?>",
            "last_name": "<?= e($last_name ?? '') ?>",
            "email": "<?= e($user['email'] ?? 'customer@example.com') ?>",
            "phone": "<?= e($order['delivery_phone'] ?? '') ?>",
            "address": "<?= e($order['delivery_address'] ?? '') ?>",
            "city": "<?= e($order['delivery_city'] ?? '') ?>",
            "country": "Sri Lanka"
        };

        // PayHere event listeners
        payhere.onCompleted = function onCompleted(orderId) {
            // Redirect to success page
            window.location.href = "<?= $return_url ?>";
        };

        payhere.onDismissed = function onDismissed() {
            console.log("Payment popup closed");
        };

        payhere.onError = function onError(error) {
            alert("Error: " + error);
        };

        // Start payment process
        document.getElementById('payhere-payment').onclick = function (e) {
            payhere.startPayment(payment);
        };
        
        // Auto-start on load
        window.onload = function() {
            setTimeout(function() {
                payhere.startPayment(payment);
            }, 500);
        };
    </script>
</body>
</html>
