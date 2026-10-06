<?php
require_once __DIR__ . '/includes/header.php';
?>

<div style="background-color: var(--vp-cream-dark); padding: 4rem 0;">
    <div class="container">
        <h1 style="text-align: center; color: var(--vp-burgundy-dark); font-size: 2.5rem; margin-bottom: 1rem;">Delivery Information</h1>
        <p style="text-align: center; max-width: 600px; margin: 0 auto; color: var(--vp-text-muted); font-size: 1.1rem;">
            Fast, reliable, and fresh delivery directly to your doorstep. Here is everything you need to know about receiving your beautiful blooms.
        </p>
    </div>
</div>

<div class="container" style="padding: 4rem 0; max-width: 800px; margin: 0 auto;">
    
    <div class="vp-card" style="margin-bottom: 2rem; padding: 2.5rem; background: #fff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #eaeaea;">
        <h2 style="color: var(--vp-burgundy); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-truck" style="color: var(--vp-pink-accent);"></i> Delivery Areas & Zones
        </h2>
        <p style="line-height: 1.8; margin-bottom: 1rem;">
            We currently deliver across Kegalle and surrounding regions. We make sure that our bouquets are transported safely in climate-controlled vehicles to ensure maximum freshness upon arrival.
        </p>
        <ul style="line-height: 1.8; margin-left: 1.5rem; color: var(--vp-text-main);">
            <li><strong>Zone 1 (Kegalle Town Limits):</strong> Same-day delivery available.</li>
            <li><strong>Zone 2 (Outer Kegalle & Suburbs):</strong> Next-day delivery available.</li>
            <li><strong>Zone 3 (Extended Areas):</strong> Please contact us directly to confirm delivery times.</li>
        </ul>
    </div>

    <div class="vp-card" style="margin-bottom: 2rem; padding: 2.5rem; background: #fff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #eaeaea;">
        <h2 style="color: var(--vp-burgundy); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-clock" style="color: var(--vp-pink-accent);"></i> Delivery Times & Cut-offs
        </h2>
        <p style="line-height: 1.8; margin-bottom: 1rem;">
            We know that timing is crucial for gifts and celebrations. Here is our delivery schedule:
        </p>
        <div style="background-color: var(--vp-cream); padding: 1.5rem; border-radius: 8px; border-left: 4px solid var(--vp-burgundy);">
            <p style="margin-bottom: 0.5rem;"><strong>Standard Delivery Hours:</strong> 9:00 AM – 7:00 PM (Monday – Saturday)</p>
            <p style="margin-bottom: 0.5rem;"><strong>Same-Day Delivery Cut-off:</strong> Orders must be placed before 2:00 PM.</p>
            <p style="margin-bottom: 0;"><strong>Sundays & Public Holidays:</strong> Deliveries must be scheduled at least 48 hours in advance.</p>
        </div>
    </div>

    <div class="vp-card" style="margin-bottom: 2rem; padding: 2.5rem; background: #fff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #eaeaea;">
        <h2 style="color: var(--vp-burgundy); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-money-bill-wave" style="color: var(--vp-pink-accent);"></i> Delivery Fees
        </h2>
        <p style="line-height: 1.8; margin-bottom: 1rem;">
            Delivery fees are calculated at checkout based on the delivery destination. 
        </p>
        <ul style="line-height: 1.8; margin-left: 1.5rem; color: var(--vp-text-main);">
            <li><strong>Standard Flat Rate:</strong> Rs. 15.00 (Kegalle Town limits)</li>
            <li><strong>Outer Suburbs:</strong> Variable rates apply at checkout.</li>
        </ul>
        <p style="margin-top: 1rem; color: var(--vp-text-muted); font-size: 0.9rem;">
            <em>* In-store pickup is also available free of charge at our main street location in Kegalle.</em>
        </p>
    </div>

    <div style="text-align: center; margin-top: 3rem;">
        <h3 style="color: var(--vp-burgundy-dark); margin-bottom: 1rem;">Have any questions about delivery?</h3>
        <p style="margin-bottom: 2rem;">Reach out to our support team and we'll be happy to assist you!</p>
        <a href="about.php" class="btn btn-primary" style="padding: 10px 25px;">Contact Us</a>
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
