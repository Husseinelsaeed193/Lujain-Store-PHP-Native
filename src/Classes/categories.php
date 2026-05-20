<?php
// src/Classes/Categories.php

// 1. استدعاء ملف الكلاس الأب
require_once __DIR__ . '/Model.php';

// 2. الكلاس الابن يرث من الكلاس الأب Model
class Categories extends Model {
    
    // 3. تحديد اسم الجدول الخاص بالتصنيفات
    protected $table = 'categories';

    // 4. دالة إضافة تصنيف جديد (مثل: عطور شرقية)
    public function create($name) {
        // حماية الاسم وتنظيفه من ثغرات SQL Injection
        $name = $this->db->real_escape_string($name);

        $sql = "INSERT INTO {$this->table} (name) VALUES ('$name')";
        
        // تنفيذ الاستعلام وإرجاع النتيجة
        return $this->db->query($sql);
    }

    // 5. دالة تعديل اسم تصنيف موجود مسبقاً بناءً على الـ ID
    public function update($id, $name) {
        $id   = (int)$id; // تأمين الـ ID تحسباً لأي تلاعب
        $name = $this->db->real_escape_string($name);

        $sql = "UPDATE {$this->table} SET name = '$name' WHERE id = $id";
        
        return $this->db->query($sql);
    }
}