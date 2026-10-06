<?php
require_once __DIR__ . '/config/database.php';

$merchant_id = $_POST['merchant_id'] ?? '';
$order_id = $_POST['order_id'] ?? '';
$payhere_amount = $_POST['payhere_amount'] ?? '';
$payhere_currency = $_POST['payhere_currency'] ?? '';
$status_code = $_POST['status_code'] ?? '';
$md5sig = $_POST['md5sig'] ?? '';

$merchant_secret = 'NDIxNDEyMTkzMjQwMzI1MTA4NDAyNzM1MDUwNjUxMjUzNjExNzg1MQ==';

$local_md5sig = strtoupper(
    md5(
        $merchant_id . 
        $order_id . 
        $payhere_amount . 
        $payhere_currency . 
        $status_code . 
        strtoupper(md5($merchant_secret))
    )
);

if (($local_md5sig === $md5sig) && ($status_code == 2) ) {
    // Payment success
    try {
        $stmt = $pdo->prepare("UPDATE orders SET status = 'Confirmed' WHERE id = ?");
        $stmt->execute([$order_id]);
    } catch (Exception $e) {
        // Log error
        error_log("PayHere Notify Error: " . $e->getMessage());
    }
} else if (($local_md5sig === $md5sig) && ($status_code == -1 || $status_code == -2 || $status_code == -3)) {
    // Payment failed or cancelled
    try {
        $stmt = $pdo->prepare("UPDATE orders SET status = 'Cancelled' WHERE id = ?");
        $stmt->execute([$order_id]);
    } catch (Exception $e) {
        // Log error
    }
}
?>
