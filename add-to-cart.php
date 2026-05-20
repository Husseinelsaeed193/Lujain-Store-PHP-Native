<?php
// add-to-cart.php
session_start();

// التحقق من أن الطلب قادم عبر POST وأن معرف المنتج موجود
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    
    $product_id = (int)$_POST['product_id'];
    // التقاط الكمية، وإذا لم تُحدد نعتبرها 1 تلقائياً
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    
    if ($quantity <= 0) { $quantity = 1; }

    // 1. إذا كانت السلة غير موجودة في الجلسة بعد، نقوم بإنشائها كمصفوفة فارغة
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // 2. إذا كان المنتج موجوداً مسبقاً في السلة، نزيد الكمية فقط
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        // إذا كان منتجاً جديداً، نضيفه بالكمية المحددة
        $_SESSION['cart'][$product_id] = $quantity;
    }
}

// 3. توجيه المستخدم فوراً إلى صفحة السلة لعرض المشتريات
header("Location: cart.php");
exit();