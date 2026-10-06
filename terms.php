<?php
require_once __DIR__ . '/includes/header.php';
?>

<div style="background-color: var(--vp-cream-dark); padding: 4rem 0;">
    <div class="container">
        <h1 style="text-align: center; color: var(--vp-burgundy-dark); font-size: 2.5rem; margin-bottom: 1rem;">Terms & Conditions</h1>
        <p style="text-align: center; max-width: 600px; margin: 0 auto; color: var(--vp-text-muted); font-size: 1.1rem;">
            Please read these terms and conditions carefully before using our website or placing an order.
        </p>
    </div>
</div>

<div class="container" style="padding: 4rem 0; max-width: 800px; margin: 0 auto;">
    
    <div class="vp-card" style="padding: 3rem; background: #fff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #eaeaea;">
        
        <p style="margin-bottom: 2rem; color: var(--vp-text-muted);">
            <em>Last Updated: <?= date('F j, Y') ?></em>
        </p>

        <h3 style="color: var(--vp-burgundy); margin-bottom: 1rem;">1. General Overview</h3>
        <p style="line-height: 1.8; margin-bottom: 2rem;">
            Welcome to Velvet Petals. By accessing and using this website, you agree to comply with and be bound by the following terms and conditions. If you disagree with any part of these terms, please do not use our website. 
        </p>

        <h3 style="color: var(--vp-burgundy); margin-bottom: 1rem;">2. Orders and Payment</h3>
        <p style="line-height: 1.8; margin-bottom: 1rem;">
            All orders are subject to acceptance and availability. If the flowers you ordered are not available, you will be notified and given the option to choose an alternative or cancel your order.
        </p>
        <ul style="line-height: 1.8; margin-bottom: 2rem; margin-left: 1.5rem; color: var(--vp-text-main);">
            <li>Prices on our website are listed in Sri Lankan Rupees (Rs.) and include applicable taxes.</li>
            <li>We offer Cash on Delivery, Credit/Debit Card, and Bank Transfer payment methods.</li>
            <li>Orders will not be processed until payment or a payment arrangement is confirmed.</li>
        </ul>

        <h3 style="color: var(--vp-burgundy); margin-bottom: 1rem;">3. Delivery Policy</h3>
        <p style="line-height: 1.8; margin-bottom: 2rem;">
            We aim to deliver your flowers within the time frame specified during checkout. However, delivery times are estimates and cannot be guaranteed. We are not responsible for delays caused by extreme weather, heavy traffic, or incorrect delivery information provided by the customer. Please review our <a href="delivery.php" style="color: var(--vp-info);">Delivery Information</a> page for full details.
        </p>

        <h3 style="color: var(--vp-burgundy); margin-bottom: 1rem;">4. Substitutions</h3>
        <p style="line-height: 1.8; margin-bottom: 2rem;">
            Due to seasonal availability, it may be necessary to substitute certain flowers or containers. We guarantee that any substitution will be of equal or higher value and will maintain the overall style and color theme of the arrangement you chose.
        </p>

        <h3 style="color: var(--vp-burgundy); margin-bottom: 1rem;">5. Refunds and Cancellations</h3>
        <p style="line-height: 1.8; margin-bottom: 2rem;">
            Because flowers are perishable items, we do not accept returns. However, if you are unsatisfied with the quality of your arrangement, please contact us within 24 hours of delivery with a photograph of the bouquet. Cancellations are only accepted if requested at least 24 hours before the scheduled delivery time.
        </p>

        <h3 style="color: var(--vp-burgundy); margin-bottom: 1rem;">6. Contact Information</h3>
        <p style="line-height: 1.8; margin-bottom: 0;">
            If you have any questions regarding these Terms & Conditions, please contact us at:<br>
            <strong>Velvet Petals</strong><br>
            No. 3, Main Street, Kandy Road, Kegalle<br>
            Phone: 036 2266453<br>
            Email: info@velvetpetals.com
        </p>

    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
