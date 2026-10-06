<?php
require_once __DIR__ . '/config/database.php';

$stmt = $pdo->query("SELECT id FROM products ORDER BY created_at DESC LIMIT 4");
$latest_products = $stmt->fetchAll(PDO::FETCH_COLUMN);

if (count($latest_products) == 4) {
    $images = [
        'assets/images/products/new1.jpg',
        'assets/images/products/new2.jpg',
        'assets/images/products/new3.jpg',
        'assets/images/products/new4.jpg'
    ];
    
    $updateStmt = $pdo->prepare("UPDATE products SET image_url = ? WHERE id = ?");
    for ($i = 0; $i < 4; $i++) {
        $updateStmt->execute([$images[$i], $latest_products[$i]]);
    }
    echo "Successfully updated 4 products.";
} else {
    echo "Not enough products found.";
}
?>
