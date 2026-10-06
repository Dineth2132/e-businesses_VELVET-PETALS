<?php
require_once __DIR__ . '/includes/header.php';

if (is_logged_in()) {
    redirect('account.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        $stmt = $pdo->prepare("SELECT id, full_name, password_hash, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];
            
            if ($user['role'] === 'admin') {
                redirect('admin/index.php');
            } else {
                redirect('account.php');
            }
        } else {
            $error = 'Invalid email or password.';
        }
    }
}
?>

<div class="container" style="max-width: 500px; padding: 4rem 0; min-height: 60vh;">
    <h1 style="text-align: center; margin-bottom: 2rem;">Login</h1>
    
    <?php if ($error): ?>
        <div style="background-color: #fee; color: #c00; padding: 1rem; margin-bottom: 1.5rem; border: 1px solid #fcc; border-radius: 4px;">
            <?= e($error) ?>
        </div>
    <?php endif; ?>
    
    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="<?= e($_POST['email'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%;">Sign In</button>
    </form>
    <p style="text-align: center; margin-top: 1.5rem;">Don't have an account? <a href="register.php" style="text-decoration: underline;">Register here</a></p>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
