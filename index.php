<?php
// index.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// 1. استدعاء ملف الاتصال وملفات الكلاسات التي نريد تجريبتها
require_once __DIR__ . '/db/connection.php';
require_once __DIR__ . '/src/Classes/Categories.php';
require_once __DIR__ . '/src/Classes/Users.php';

echo "<h2>تجرية محرك متجر لجين (Lujain Store Testing)</h2>";

// 2. إنشاء كائن الاتصال وجلب الرابط الفعلي
$database = new Database();
$db = $database->getConnection();

if ($db) {
    echo "<p style='color: green;'>✅ تم الاتصال بقاعدة البيانات بنجاح!</p>";
    
    // ---------------------------------------------------------
    // تجربة 1: إضافة تصنيف جديد عطور شرقية
    // ---------------------------------------------------------
    $categoryModel = new Categories($db);
    
    // سنقوم بالإضافة
    $insertCategory = $categoryModel->create("عطور شرقية");
    
    if ($insertCategory) {
        echo "<p style='color: blue;'>✅ تم إضافة تصنيف 'عطور شرقية' بنجاح!</p>";
    }
    
    // عرض كل التصنيفات الموجودة للتأكد من دالة getAll
    echo "<h3>قائمة التصنيفات الحالية:</h3>";
    $allCategories = $categoryModel->getAll();
    echo "<pre>";
    print_r($allCategories);
    echo "</pre>";

    // ---------------------------------------------------------
    // تجربة 2: إضافة مستخدم مدير (Admin) للمتجر
    // ---------------------------------------------------------
    $userModel = new Users($db);
    
    // نفحص أولاً إذا كان الإيميل غير موجود لكي لا يتكرر مع كل تحديث للصفحة
    $testEmail = "admin@lujain.com";
    if (!$userModel->emailExists($testEmail)) {
        $insertUser = $userModel->register("Ali_Dev", $testEmail, "password123", "admin");
        if ($insertUser) {
            echo "<p style='color: blue;'>✅ تم تسجيل المستخدم المدير 'Ali_Dev' بكلمة مرور مشفرة!</p>";
        }
    } else {
        echo "<p style='color: orange;'>⚠️ البريد الإلكتروني '$testEmail' مسجل مسبقاً، لم يتم التكرار.</p>";
    }

} else {
    echo "<p style='color: red;'>❌ فشل الاتصال بقاعدة البيانات، راجع ملف connection.php</p>";
}
?>