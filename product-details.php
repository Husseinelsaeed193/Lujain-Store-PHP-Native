<?php
// product-details.php

// 1. تفعيل عرض الأخطاء في بيئة التطوير
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2. استدعاء المحرك والاتصال
require_once __DIR__ . '/db/connection.php';
require_once __DIR__ . '/src/Classes/Products.php';

$database = new Database();
$db = $database->getConnection();

// 3. التقاط الـ ID القادم من الرابط وفحصه وتأمينه
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$productModel = new Products($db);
// استدعاء الدالة السحرية المشتركة من الأب Model بجلب بيانات عطر واحد
$product = $productModel->getById($product_id);

// 4. إذا كان العطر غير موجود أو الـ ID خاطئ، نوجه المستخدم للرئيسية أو نظهر رسالة
if (!$product) {
    header("Location: index.php");
    exit();
}

// 5. استدعاء الهيدر المشترك
include_once __DIR__ . '/includes/header.php';
?>

<div class="container my-5">
    <a href="index.php" class="btn btn-outline-dark mb-4">⬅️ العودة للرئيسية</a>

    <div class="row g-5 bg-white p-4 rounded-3 shadow-sm">
        <div class="col-md-6 text-center">
            <?php 
            $imagePath = "assets/images/" . $product['image'];
            $displayImage = (!empty($product['image']) && file_exists(__DIR__ . '/' . $imagePath)) ? $imagePath : 'default_perfume.jpg';
            ?>
            <img src="<?php echo $displayImage; ?>" class="img-fluid rounded-3 shadow-sm p-3" alt="<?php echo $product['name']; ?>" style="max-height: 500px; object-fit: contain;">
        </div>

        <div class="col-md-6 d-flex flex-column justify-content-center">
            <span class="badge bg-dark align-self-start mb-2 py-2 px-3 fs-6">عطور نيش فاخرة</span>
            <h1 class="fw-bold text-dark mb-3"><?php echo $product['name']; ?></h1>
            
            <h3 class="text-danger fw-bold mb-4"><?php echo $product['price']; ?> ر.س</h3>
            
            <hr>
            
            <h5 class="fw-bold text-secondary">وصف العطر:</h5>
            <p class="lead text-muted mb-4" style="line-height: 1.8;">
                <?php echo $product['description']; ?>
            </p>
            
            <div class="mb-4">
                <span class="fw-bold text-secondary">الحجم المتوفر:</span>
                <span class="badge bg-secondary ms-2 p-2 fs-6"><?php echo $product['size']; ?> مل</span>
            </div>

            <div class="mb-4">
                <span class="fw-bold text-secondary">حالة التوفر في المخزن:</span>
                <?php if ($product['stock'] > 0): ?>
                    <span class="text-success fw-bold ms-2">✅ متوفر حالياً (جاهز للشحن الفوري)</span>
                <?php else: ?>
                    <span class="text-danger fw-bold ms-2">❌ غير متوفر حالياً</span>
                <?php endif; ?>
            </div>
            
            <hr class="mb-4">
            
            <form action="add-to-cart.php" method="POST" class="row g-3 align-items-center">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                
                <div class="col-auto">
                    <label for="quantity" class="fw-bold text-secondary">الكمية:</label>
                </div>
                <div class="col-3">
                    <input type="number" name="quantity" id="quantity" class="form-control text-center" value="1" min="1" max="<?php echo $product['stock']; ?>">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-dark w-100 py-3 fw-bold fs-5">إضافة إلى سلة المشتريات 🛒</button>
                </div>
            </form>
            
        </div>
    </div>
</div>

<?php 
// 6. استدعاء الفوتر المشترك
include_once __DIR__ . '/includes/footer.php'; 
?>