<?php
require_once __DIR__ . '/includes/header.php';
?>

<div style="background-color: var(--vp-cream-dark); padding: 4rem 0;">
    <div class="container">
        <h1 style="text-align: center; color: var(--vp-burgundy-dark); font-size: 2.5rem; margin-bottom: 1rem;">About Velvet Petals</h1>
        <p style="text-align: center; max-width: 600px; margin: 0 auto; color: var(--vp-text-muted); font-size: 1.1rem;">
            Flowers for the moments that deserve to be remembered. We are dedicated to providing the freshest and most beautiful blooms.
        </p>
    </div>
</div>

<div class="container" style="padding: 4rem 0;">
    <div style="display: flex; gap: 3rem; align-items: center; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 300px;">
            <img src="assets/images/logo.jpg" alt="Velvet Petals" style="width: 100%; max-width: 400px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); margin: 0 auto; display: block;">
        </div>
        
        <div style="flex: 1; min-width: 300px;">
            <h2 style="color: var(--vp-burgundy); margin-bottom: 1.5rem;">Our Story</h2>
            <p style="margin-bottom: 1rem; line-height: 1.8;">
                Welcome to Velvet Petals! Based in the heart of Kegalle, we believe that every flower tells a story. From joyous celebrations to moments of quiet comfort, our carefully curated bouquets are designed to convey your deepest emotions.
            </p>
            <p style="margin-bottom: 1rem; line-height: 1.8;">
                Our expert florists hand-select the freshest seasonal blooms to craft premium, elegant arrangements. Whether you're looking for vibrant spring tulips, luxurious orchids, classic red roses, or unique mixed bouquets, we ensure top-tier quality and an unforgettable unboxing experience.
            </p>
            
            <h3 style="color: var(--vp-burgundy); margin-top: 2rem; margin-bottom: 1rem;">Our Details</h3>
            <ul style="list-style: none; padding: 0;">
                <li style="margin-bottom: 0.8rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-map-marker-alt" style="color: var(--vp-pink-accent); width: 20px;"></i>
                    <span><strong>Address:</strong> No. 3, Main Street, Kandy Road, Kegalle</span>
                </li>
                <li style="margin-bottom: 0.8rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-phone" style="color: var(--vp-pink-accent); width: 20px;"></i>
                    <span><strong>Contact Number:</strong> 036 2266453</span>
                </li>
                <li style="margin-bottom: 0.8rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fab fa-whatsapp" style="color: var(--vp-pink-accent); width: 20px;"></i>
                    <span><strong>WhatsApp:</strong> 0772342345</span>
                </li>
                <li style="margin-bottom: 0.8rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-envelope" style="color: var(--vp-pink-accent); width: 20px;"></i>
                    <span><strong>Email:</strong> info@velvetpetals.com</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<div style="background-color: var(--vp-burgundy); color: white; padding: 4rem 0; text-align: center;">
    <div class="container">
        <h2 style="margin-bottom: 1rem;">Ready to find the perfect bouquet?</h2>
        <p style="margin-bottom: 2rem; opacity: 0.9;">Browse our extensive collection of premium flowers.</p>
        <a href="shop.php" class="btn btn-primary" style="background-color: var(--vp-cream); color: var(--vp-burgundy); padding: 12px 30px; font-weight: 600;">Shop Now</a>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
