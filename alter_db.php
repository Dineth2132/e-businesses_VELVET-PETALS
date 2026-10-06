<?php
require 'config/database.php';
try {
    $pdo->exec("ALTER TABLE orders ADD COLUMN payment_method VARCHAR(50) DEFAULT 'Cash on Delivery'");
    echo "Column added successfully";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
