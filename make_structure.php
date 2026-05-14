<?php
// قائمة المجلدات المراد إنشاؤها
$folders = [
    'assets/css', 'assets/js', 'assets/images', 'assets/vendor',
    'includes', 'db', 'src/Classes', 'src/Helpers', 'uploads'
];

// قائمة الملفات المراد إنشاؤها
$files = [
    'index.php', 'config.php', '.htaccess',
    'includes/header.php', 'includes/footer.php', 'includes/navbar.php',
    'db/connection.php', 'src/Classes/User.php', 'src/Classes/Product.php',
    'src/Classes/Order.php', 'src/Helpers/functions.php'
];

// إنشاء المجلدات
foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
        echo "Created folder: $folder <br>";
    }
}

// إنشاء الملفات
foreach ($files as $file) {
    if (!file_exists($file)) {
        file_put_contents($file, "<?php\n\n// $file");
        echo "Created file: $file <br>";
    }
}

echo "--- Project Structure Created Successfully ---";