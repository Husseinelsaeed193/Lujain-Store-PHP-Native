<?php
// src/Classes/Users.php

// 1. استدعاء ملف الكلاس الأب
require_once __DIR__ . '/Model.php';

// 2. الكلاس الابن يرث من الكلاس الأب Model
class Users extends Model {
    
    // 3. تحديد اسم الجدول الخاص بالمستخدمين
    protected $table = 'users';

    // 4. دالة تسجيل مستخدم (أو مدير) جديد
    public function register($username, $email, $password, $role = 'customer') {
        // تنظيف وحماية البيانات من ثغرات SQL Injection
        $username = $this->db->real_escape_string($username);
        $email    = $this->db->real_escape_string($email);
        $role     = $this->db->real_escape_string($role);
        
        // تأمين وتشفيير كلمة المرور قبل حفظها في قاعدة البيانات
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // كتابة استعلام الإدخال
        $sql = "INSERT INTO {$this->table} (username, email, password, role) 
                VALUES ('$username', '$email', '$hashed_password', '$role')";
        
        // تنفيذ الاستعلام
        return $this->db->query($sql);
    }

    // 5. دالة فحص البريد الإلكتروني لمنع التسجيل بنفس الحساب مرتين
    public function emailExists($email) {
        $email = $this->db->real_escape_string($email);
        
        $sql = "SELECT id FROM {$this->table} WHERE email = '$email'";
        $result = $this->db->query($sql);
        
        // إذا كان عدد الصفوف المسترجعة أكبر من 0، فهذا يعني أن الإيميل موجود ومسجل مسبقاً
        return $result->num_rows > 0; 
    }
}