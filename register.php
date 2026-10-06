<?php
require_once __DIR__ . '/includes/header.php';

if (is_logged_in()) {
    redirect('account.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($full_name) || empty($email) || empty($password)) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'Email already registered.';
        } else {
            // Register user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)");
            if ($stmt->execute([$full_name, $email, $hashed_password])) {
                $success = 'Registration successful! You can now login.';
            } else {
                $error = 'Something went wrong. Please try again.';
            }
        }
    }
}
?>

<div class="container" style="max-width: 500px; padding: 4rem 0;">
    <h1 style="text-align: center; margin-bottom: 2rem;">Create Account</h1>
    
    <?php if ($error): ?>
        <div style="background-color: #fee; color: #c00; padding: 1rem; margin-bottom: 1.5rem; border: 1px solid #fcc; border-radius: 4px;">
            <?= e($error) ?>
        </div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div style="background-color: #efe; color: #090; padding: 1rem; margin-bottom: 1.5rem; border: 1px solid #cfc; border-radius: 4px;">
            <?= e($success) ?> <a href="login.php">Login here</a>
        </div>
    <?php else: ?>
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="full_name">Full Name *</label>
                <input type="text" id="full_name" name="full_name" value="<?= e($_POST['full_name'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" value="<?= e($_POST['email'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password *</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Register</button>
        </form>
        <p style="text-align: center; margin-top: 1.5rem;">Already have an account? <a href="login.php" style="text-decoration: underline;">Login</a></p>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
