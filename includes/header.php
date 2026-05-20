<?php 
// 1. تفعيل الجلسة في أول السطر لضمان قراءة بيانات تسجيل الدخول في كل الصفحات
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>متجر لجين للعطور | Lujain Store</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f8f9fa; }
        .navbar { background-color: #1a1a1a; }
        .navbar-brand, .nav-link { color: #fff !important; }
        .card-product { transition: transform 0.2s; }
        .card-product:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">🛍️ متجر لجين</a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link active" href="index.php">الرئيسية</a></li>
                <li class="nav-item"><a class="nav-link" href="#">العطور</a></li>
                <li class="nav-item"><a class="nav-link" href="#">التصنيفات</a></li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item bg-secondary rounded-3 px-2 mx-2">
                        <span class="nav-link text-white small">👋 مرحباً، <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger fw-bold" href="logout.php">تسجيل الخروج</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link fw-bold text-info" href="login.php">تسجيل الدخول 🔑</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>