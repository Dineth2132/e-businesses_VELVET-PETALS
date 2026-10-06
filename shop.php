<?php
require_once __DIR__ . '/includes/header.php';

// Pagination and Filtering logic
$category = $_GET['category'] ?? '';
$occasion = $_GET['occasion'] ?? '';
$search = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? 'newest';

$query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.is_available = 1";
$params = [];

if ($category) {
    $query .= " AND c.slug = ?";
    $params[] = $category;
}
if ($search) {
    $query .= " AND (p.name LIKE ? OR p.description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

switch($sort) {
    case 'price_asc': $query .= " ORDER BY p.price ASC"; break;
    case 'price_desc': $query .= " ORDER BY p.price DESC"; break;
    case 'rating': $query .= " ORDER BY p.rating DESC"; break;
    case 'bestseller': $query .= " ORDER BY p.bestseller DESC, p.created_at DESC"; break;
    default: $query .= " ORDER BY p.created_at DESC"; break;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll();

// Fetch categories for filter
$cat_stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
$all_categories = $cat_stmt->fetchAll();
?>
<style>
    .product-card {
        background-color: var(--color-secondary);
        border-radius: 8px;
        overflow: hidden;
        transition: var(--transition);
        text-align: left;
        position: relative;
        border: 1px solid #eaeaea;
        display: flex;
        flex-direction: column;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
    }
    .product-img-wrapper {
        position: relative;
        width: 100%;
        aspect-ratio: 4/5;
        overflow: hidden;
        background-color: #f0f0f0;
    }
    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .product-card:hover .product-img {
        transform: scale(1.05);
    }
    .badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: var(--color-accent);
        color: white;
        padding: 4px 10px;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 4px;
        z-index: 2;
    }
    .card-content {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .product-title {
        font-family: var(--font-heading);
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
        color: var(--color-primary);
    }
    .rating {
        color: #eab308;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .rating-count { color: #666; }
    .price {
        font-weight: 600;
        font-size: 1.2rem;
        margin-bottom: 1.5rem;
    }
    .card-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: auto;
    }
    .card-actions .btn {
        padding: 0.8rem;
        font-size: 0.85rem;
        flex: 1;
        text-align: center;
    }
    .btn-icon {
        background-color: transparent;
        border: 1px solid #ddd;
        color: var(--color-primary);
        width: 45px;
        flex: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-icon:hover {
        background-color: var(--color-accent);
        color: white;
        border-color: var(--color-accent);
    }
</style>

<div class="container" style="padding: 4rem 0;">
    <div style="display: flex; gap: 3rem;">
        
        <!-- Sidebar Filters -->
        <aside style="width: 250px; flex-shrink: 0;">
            <h3 style="margin-bottom: 1.5rem; font-family: var(--font-heading);">Filters</h3>
            <form action="shop.php" method="GET">
                <div style="margin-bottom: 2rem;">
                    <h4 style="font-size: 1.1rem; margin-bottom: 1rem;">Search</h4>
                    <input type="text" name="search" value="<?= e($search) ?>" placeholder="Search bouquets..." style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                
                <div style="margin-bottom: 2rem;">
                    <h4 style="font-size: 1.1rem; margin-bottom: 1rem;">Sort By</h4>
                    <select name="sort" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Newest Arrivals</option>
                        <option value="bestseller" <?= $sort === 'bestseller' ? 'selected' : '' ?>>Best Selling</option>
                        <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
                        <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
                        <option value="rating" <?= $sort === 'rating' ? 'selected' : '' ?>>Highest Rated</option>
                    </select>
                </div>
                
                <div style="margin-bottom: 2rem;">
                    <h4 style="font-size: 1.1rem; margin-bottom: 1rem;">Categories</h4>
                    <ul style="list-style: none;">
                        <li style="margin-bottom: 0.8rem;"><a href="shop.php" style="color: <?= !$category ? 'var(--color-accent-dark)' : 'inherit' ?>">All Flowers</a></li>
                        <?php foreach ($all_categories as $cat): ?>
                            <li style="margin-bottom: 0.8rem;">
                                <a href="shop.php?category=<?= e($cat['slug']) ?>" style="color: <?= $category === $cat['slug'] ? 'var(--color-accent-dark)' : 'inherit' ?>">
                                    <?= e($cat['name']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">Apply Filters</button>
            </form>
        </aside>

        <!-- Product Grid -->
        <main style="flex: 1;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h1 style="font-size: 2.5rem; font-family: var(--font-heading);">
                    <?= $category ? ucfirst(e($category)) : ($search ? 'Search Results' : 'All Floral Collections') ?>
                </h1>
                <p style="color: #666;"><?= count($products) ?> items found</p>
            </div>
            
            <div class="product-grid" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem;">
                <?php if (count($products) > 0): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <div class="product-img-wrapper">
                                <?php if ($product['bestseller']): ?>
                                    <span class="badge">Best Seller</span>
                                <?php elseif ($product['featured']): ?>
                                    <span class="badge" style="background-color: var(--color-botanical);">Featured</span>
                                <?php endif; ?>
                                <a href="product.php?id=<?= $product['id'] ?>">
                                    <img src="<?= e($product['image_url']) ?>" alt="<?= e($product['name']) ?>" class="product-img" loading="lazy">
                                </a>
                            </div>
                            <div class="card-content">
                                <a href="product.php?id=<?= $product['id'] ?>">
                                    <h3 class="product-title"><?= e($product['name']) ?></h3>
                                </a>
                                
                                <div class="rating">
                                    ★★★★★ <span class="rating-count"><?= number_format($product['rating'], 1) ?> (<?= e($product['review_count']) ?> reviews)</span>
                                </div>
                                
                                <div class="price">Rs. <?= number_format($product['price'], 2) ?></div>
                                
                                <div class="card-actions">
                                    <form action="cart.php" method="POST" style="flex: 1;">
                                        <input type="hidden" name="action" value="add">
                                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary" style="width: 100%;">Add to Cart</button>
                                    </form>
                                    <button class="btn btn-icon" title="Add to Wishlist">♡</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="grid-column: 1 / -1; text-align: center; padding: 6rem 0;">
                        <div style="font-size: 3rem; margin-bottom: 1rem; color: #ccc;">🌸</div>
                        <p style="font-size: 1.2rem; color: #666;">No arrangements found matching your criteria.</p>
                        <a href="shop.php" class="btn btn-primary" style="margin-top: 1.5rem;">Clear Filters</a>
                    </div>
                <?php endif; ?>
            </div>
        </main>
        
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
