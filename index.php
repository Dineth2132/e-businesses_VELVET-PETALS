<?php
require_once __DIR__ . '/includes/header.php';

// Fetch categories for homepage
$stmt = $pdo->query("SELECT * FROM categories LIMIT 5");
$categories = $stmt->fetchAll();

// Fetch featured products (latest 4 available)
$stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.is_available = 1 ORDER BY p.created_at DESC LIMIT 4");
$featured_products = $stmt->fetchAll();
?>

<section class="hero-slider-container" style="position: relative; height: 80vh; overflow: hidden; color: var(--color-secondary); text-align: center;">
    <!-- Slides -->
    <div class="hero-slide active" style="background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('assets/images/hero.jpg');"></div>
    <div class="hero-slide" style="background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('assets/images/hero2.jpg');"></div>
    <div class="hero-slide" style="background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('assets/images/hero3.jpg');"></div>

    <!-- Content overlay (stays static while background fades) -->
    <div class="hero-content" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 10; width: 100%; max-width: 800px;">
        <h1 style="font-size: 4rem; margin-bottom: 1.5rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Flowers That Speak From the Heart</h1>
        <p style="font-size: 1.2rem; margin-bottom: 2rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">Beautifully arranged flowers for every special moment, carefully prepared and delivered with love.</p>
        <a href="shop.php" class="btn btn-primary" style="margin: 0 0.5rem; background-color: var(--color-accent); border: none;">Shop Bouquets</a>
        <a href="shop.php?occasion=true" class="btn btn-secondary" style="margin: 0 0.5rem; color: white; border-color: white;">Explore Collections</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.hero-slide');
            let currentSlide = 0;
            
            setInterval(() => {
                slides[currentSlide].classList.remove('active');
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].classList.add('active');
            }, 5000); // Change image every 5 seconds
        });
    </script>
</section>

<section class="categories container">
    <h2 class="section-title">Shop by Category</h2>
    <div class="category-grid">
        <?php foreach ($categories as $cat): ?>
            <a href="shop.php?category=<?= e($cat['slug']) ?>" class="category-card">
                <img src="<?= e($cat['image_url']) ?>" alt="<?= e($cat['name']) ?>" class="category-img">
                <h3 class="category-name"><?= e($cat['name']) ?></h3>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<section class="featured">
    <div class="container">
        <h2 class="section-title">New Arrivals</h2>
        <div class="product-grid">
            <?php if (count($featured_products) > 0): ?>
                <?php foreach ($featured_products as $product): ?>
                    <div class="product-card" style="border-radius: 8px; border: 1px solid #eaeaea; display: flex; flex-direction: column; overflow: hidden; background: #fff;">
                        <a href="product.php?id=<?= $product['id'] ?>" style="display: block; width: 100%; aspect-ratio: 4/5; overflow: hidden;">
                            <img src="<?= e($product['image_url']) ?>" alt="<?= e($product['name']) ?>" style="width: 100%; height: 100%; object-fit: cover;" class="product-img">
                        </a>
                        <div style="padding: 1.5rem; flex: 1; display: flex; flex-direction: column; text-align: left;">
                            <h3 class="product-title" style="font-size: 1.25rem; margin-bottom: 0.5rem;"><a href="product.php?id=<?= $product['id'] ?>"><?= e($product['name']) ?></a></h3>
                            <p style="color: #666; margin-bottom: 1rem;"><?= e($product['category_name']) ?></p>
                            <div style="font-weight: 600; font-size: 1.2rem; margin-bottom: 1.5rem;">Rs. <?= number_format($product['price'], 2) ?></div>
                            <a href="product.php?id=<?= $product['id'] ?>" class="btn btn-primary" style="margin-top: auto; text-align: center;">View Details</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center;">More beautiful arrangements coming soon.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="promo">
    <div class="container">
        <h2>Freshness from our hands to your door.</h2>
        <p style="max-width: 600px; margin: 1.5rem auto; font-size: 1.1rem;">We believe in the power of fresh flowers. Every stem is carefully selected and arranged by our expert florists to ensure your gift arrives looking spectacular and lasts longer. Delivered with care, straight to your chosen address.</p>
        <a href="shop.php" class="btn btn-primary" style="background-color: var(--color-secondary); color: var(--color-primary);">Learn More</a>
    </div>
</section>

<section class="newsletter container" style="padding: 5rem 0; text-align: center; max-width: 600px;">
    <h2>Join the Velvet Petals Family</h2>
    <p style="margin-bottom: 2rem;">Subscribe to receive updates on seasonal arrangements, special offers, and floral inspiration.</p>
    <form action="#" method="POST" style="display: flex; gap: 1rem;">
        <input type="email" placeholder="Your email address" style="flex: 1; padding: 1rem; border: 1px solid #ccc; font-family: var(--font-body);" required>
        <button type="submit" class="btn btn-primary">Subscribe</button>
    </form>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
