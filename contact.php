<?php
require_once __DIR__ . '/includes/header.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'Please fill out all fields before submitting.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        // Here you would normally insert into a database or send an email.
        // For demonstration, we simply mark it as successful.
        $success = true;
    }
}
?>

<div style="background-color: var(--vp-cream-dark); padding: 4rem 0;">
    <div class="container">
        <h1 style="text-align: center; color: var(--vp-burgundy-dark); font-size: 2.5rem; margin-bottom: 1rem;">Contact Us</h1>
        <p style="text-align: center; max-width: 600px; margin: 0 auto; color: var(--vp-text-muted); font-size: 1.1rem;">
            We'd love to hear from you. Whether you have a question about an order, a custom arrangement, or just want to say hello!
        </p>
    </div>
</div>

<div class="container" style="padding: 4rem 0; display: flex; gap: 4rem; flex-wrap: wrap;">
    
    <!-- Contact Details -->
    <div style="flex: 1; min-width: 300px;">
        <h2 style="color: var(--vp-burgundy); margin-bottom: 1.5rem;">Get In Touch</h2>
        <p style="margin-bottom: 2rem; line-height: 1.8;">
            Have a special request or need help finding the perfect bouquet? Reach out to us using the contact details below, and our team will get back to you as soon as possible.
        </p>
        
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div style="display: flex; align-items: flex-start; gap: 15px;">
                <div style="background-color: var(--vp-pink-subtle); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--vp-burgundy);">
                    <i class="fas fa-map-marker-alt" style="font-size: 1.2rem;"></i>
                </div>
                <div>
                    <h4 style="margin-bottom: 5px; color: var(--vp-burgundy-dark);">Our Location</h4>
                    <p style="color: var(--vp-text-muted);">No. 3, Main Street<br>Kandy Road, Kegalle</p>
                </div>
            </div>
            
            <div style="display: flex; align-items: flex-start; gap: 15px;">
                <div style="background-color: var(--vp-pink-subtle); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--vp-burgundy);">
                    <i class="fas fa-phone" style="font-size: 1.2rem;"></i>
                </div>
                <div>
                    <h4 style="margin-bottom: 5px; color: var(--vp-burgundy-dark);">Phone</h4>
                    <p style="color: var(--vp-text-muted);">036 2266453</p>
                </div>
            </div>
            
            <div style="display: flex; align-items: flex-start; gap: 15px;">
                <div style="background-color: var(--vp-pink-subtle); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--vp-burgundy);">
                    <i class="fab fa-whatsapp" style="font-size: 1.2rem;"></i>
                </div>
                <div>
                    <h4 style="margin-bottom: 5px; color: var(--vp-burgundy-dark);">WhatsApp</h4>
                    <p style="color: var(--vp-text-muted);">0772342345</p>
                </div>
            </div>
            
            <div style="display: flex; align-items: flex-start; gap: 15px;">
                <div style="background-color: var(--vp-pink-subtle); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--vp-burgundy);">
                    <i class="fas fa-envelope" style="font-size: 1.2rem;"></i>
                </div>
                <div>
                    <h4 style="margin-bottom: 5px; color: var(--vp-burgundy-dark);">Email</h4>
                    <p style="color: var(--vp-text-muted);">info@velvetpetals.com</p>
                </div>
            </div>
        </div>
        
        <h3 style="color: var(--vp-burgundy); margin-top: 3rem; margin-bottom: 1rem;">Store Hours</h3>
        <ul style="list-style: none; padding: 0; color: var(--vp-text-muted);">
            <li style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">
                <span>Monday - Saturday</span> <span>9:00 AM - 7:00 PM</span>
            </li>
            <li style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                <span>Sunday</span> <span>Closed</span>
            </li>
        </ul>
    </div>
    
    <!-- Contact Form -->
    <div style="flex: 1.5; min-width: 300px;">
        <div class="vp-card" style="padding: 2.5rem; background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid #eaeaea;">
            <h3 style="color: var(--vp-burgundy); margin-bottom: 1.5rem;">Send a Message</h3>
            
            <?php if ($success): ?>
                <div class="vp-alert vp-alert-success" style="background-color: #e8f5e9; color: #2e7d32; padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem; border: 1px solid #c8e6c9;">
                    <i class="fas fa-check-circle"></i> Thank you! Your message has been sent successfully. We will be in touch shortly.
                </div>
            <?php else: ?>
            
                <?php if ($error): ?>
                    <div class="vp-alert vp-alert-danger" style="background-color: #fee; color: #c00; padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem; border: 1px solid #fcc;">
                        <i class="fas fa-exclamation-circle"></i> <?= e($error) ?>
                    </div>
                <?php endif; ?>
            
                <form action="contact.php" method="POST">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Your Name *</label>
                            <input type="text" id="name" name="name" class="vp-form-control" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px;" required value="<?= isset($_POST['name']) ? e($_POST['name']) : '' ?>">
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Your Email *</label>
                            <input type="email" id="email" name="email" class="vp-form-control" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px;" required value="<?= isset($_POST['email']) ? e($_POST['email']) : '' ?>">
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label for="subject" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Subject *</label>
                        <input type="text" id="subject" name="subject" class="vp-form-control" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px;" required value="<?= isset($_POST['subject']) ? e($_POST['subject']) : '' ?>">
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 2rem;">
                        <label for="message" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Message *</label>
                        <textarea id="message" name="message" class="vp-form-control" rows="6" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; resize: vertical;" required><?= isset($_POST['message']) ? e($_POST['message']) : '' ?></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="padding: 14px 30px; font-size: 1.1rem; width: 100%;">Send Message</button>
                </form>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
