<?php
$pages = ['payments' => 'Payments', 'inventory' => 'Inventory', 'offers' => 'Offers & Discounts', 'reviews' => 'Reviews', 'messages' => 'Messages', 'reports' => 'Reports', 'profile' => 'Admin Profile'];

foreach ($pages as $file => $title) {
    $content = <<<PHP
<?php
require_once __DIR__ . '/../includes/functions.php';

if (!is_admin()) {
    redirect('../login.php');
}

\$page_title = '$title';
require_once 'includes/header.php';
?>

<div class="admin-table-container" style="padding: 3rem; text-align: center;">
    <h2 style="color: var(--admin-secondary);">Coming Soon</h2>
    <p>The <strong>$title</strong> module is currently under development.</p>
</div>

<?php require_once 'includes/footer.php'; ?>
PHP;
    file_put_contents(__DIR__ . "/admin/{$file}.php", $content);
}
echo "Scaffolding complete.";
