<?php
// src/Classes/Users.php

class Users {
    // تعريف الخصائص المحمية للكلاس لكي لا تظهر رسائل الـ Warning
    protected $conn;
    protected $table_name = "users";

    // الباني (Constructor) لاستقبال كائن الاتصال بقاعدة البيانات
    public function __construct($db) {
        $this->conn = $db;
    }

    // دالة تسجيل الدخول والتحقق من الحساب
    public function login($email, $password) {
        // كتابة الاستعلام المتوافق مع mysqli باستخدام علامة الاستفهام لحماية البيانات
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ? LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        
        if ($stmt) {
            // ربط المتغير القادم من المستخدم (s تعني string)
            $stmt->bind_param("s", $email);
            $stmt->execute();
            
            // جلب النتيجة
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                
                // التحقق من كلمة المرور (سواء كانت مشفرة بـ password_verify أو نص عادي حسب إعدادك الحالي)
                // يفضل دائماً استخدام password_verify إن كانت مشفرة في قاعدة البيانات
                if ($password === $user['password'] || password_verify($password, $user['password'])) {
                    return $user; // إعادة بيانات المستخدم كاملة في حال نجاح المطابقة
                }
            }
            $stmt->close();
        }
        
        return false; // فشل تسجيل الدخول
    }
}