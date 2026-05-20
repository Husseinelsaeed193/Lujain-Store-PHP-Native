<?php
// login.php
session_start();

// إذا كان المستخدم مسجل دخوله بالفعل، يتم توجيهه للرئيسية
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/db/connection.php';
require_once __DIR__ . '/src/Classes/Users.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $userModel = new Users($db);

    $email = $_POST['email'];
    $password = $_POST['password'];

    // محاولة تسجيل الدخول
    $userData = $userModel->login($email, $password);

    if ($userData) {
        // تخزين بيانات المستخدم في الجلسة (Session)
        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['user_name'] = $userData['username'];
        $_SESSION['user_role'] = $userData['role'];

        // التوجيه للصفحة الرئيسية بعد النجاح
        header("Location: index.php");
        exit();
    } else {
        $error = "❌ البريد الإلكتروني أو كلمة المرور غير صحيحة!";
    }
}

include_once __DIR__ . '/includes/header.php';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm p-4 rounded-3 bg-white">
                <h2 class="fw-bold text-center text-dark mb-4">تسجيل الدخول ✨</h2>
                
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger text-center py-2"><?php echo $error; ?></div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold text-secondary">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" class="form-control py-2" placeholder="admin@lujain.com" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label fw-bold text-secondary">كلمة المرور</label>
                        <input type="password" name="password" id="password" class="form-control py-2" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn btn-dark w-100 py-2 fw-bold fs-5 mb-3">دخول للمتجر 🛒</button>
                </form>
                
                <p class="text-center text-muted small mb-0">الحساب التجريبي: admin@lujain.com | password123</p>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/includes/footer.php'; ?>