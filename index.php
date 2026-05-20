<?php
// index.php

// 1. تفعيل عرض الأخطاء في بيئة التطوير المحلية
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2. استدعاء المحرك والاتصال
require_once __DIR__ . '/db/connection.php';
require_once __DIR__ . '/src/Classes/Products.php';

$database = new Database();
$db = $database->getConnection();

// 3. جلب العطور من كلاس Products
$productModel = new Products($db);
$allProducts = $productModel->getAll();

// 4. استدعاء الهيدر (التصميم العلوي)
include_once __DIR__ . '/includes/header.php';
?>

<div class="container my-4">
    <div class="bg-white p-5 rounded-3 shadow-sm mb-5 text-center">
        <h1 class="fw-bold text-dark">مرحباً بك في متجر لجين للعطور ✨</h1>
        <p class="lead text-muted">اكتشف مجموعتنا الحصرية من عطور النيش والروائح الشرقية والفرنسية الفاخرة.</p>
    </div>

    <h2 class="fw-bold mb-4">🔥 أحدث العطور المتاحة:</h2>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if (!empty($allProducts)): ?>
            <?php foreach ($allProducts as $product): ?>
                <div class="col">
                    <div class="card h-100 card-product border-0 shadow-sm">
<img src="assets/images/<?php echo (!empty($product['image'])) ? $product['image'] : 'default_perfume.jpg'; ?>?v=<?php echo time(); ?>" class="card-img-top p-3" alt="<?php echo $product['name']; ?>" style="height: 250px; object-fit: contain;">                        <div class="card-body d-flex flex-column text-center">
                            <h5 class="card-title fw-bold"><?php echo $product['name']; ?></h5>
                            <p class="card-text text-muted flex-grow-1 text-truncate"><?php echo $product['description']; ?></p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="badge bg-secondary p-2"><?php echo $product['size']; ?> مل</span>
                                <span class="text-danger fw-bold fs-5"><?php echo $product['price']; ?> ر.س</span>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-3">
                            <button class="btn btn-dark w-100 py-2 fw-bold">إضافة للسلة 🛒</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center my-5">
                <p class="text-muted fs-4">⚠️ لا توجد عطور متوفرة في قاعدة البيانات حالياً.</p>
                <p class="small text-secondary">يمكنك إضافة عطور يدوياً من phpMyAdmin في جدول products لتراها تظهر هنا فوراً!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php 
// 5. استدعاء الفوتر (التصميم السفلي)
include_once __DIR__ . '/includes/footer.php'; 
?>