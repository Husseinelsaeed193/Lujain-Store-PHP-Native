<?php
// src/Classes/Products.php

// 1. استدعاء ملف الكلاس الأب للتأكد من وجوده
require_once __DIR__ . '/Model.php';

// 2. الكلاس الابن يرث الكلاس الأب باستخدام كلمة extends
class Products extends Model {
    
    // 3. تحديد اسم الجدول الخاص بهذا الكلاس ليعرف الأب أين ينفذ العمليات
    protected $table = 'products';

    // 4. دالة إضافة عطر جديد إلى قاعدة البيانات
    public function create($data) {
        // تنظيف وحماية البيانات النصية من ثغرات SQL Injection
        $name        = $this->db->real_escape_string($data['name']);
        $description = $this->db->real_escape_string($data['description']);
        $size        = $this->db->real_escape_string($data['size']);
        $image       = $this->db->real_escape_string($data['image']);
        
        // تحويل البيانات الرقمية لنوعها الصحيح لضمان سلامة البيانات
        $category_id = (int)$data['category_id'];
        $price       = (float)$data['price'];
        $stock       = (int)$data['stock'];

        // كتابة استعلام الإدخال
        $sql = "INSERT INTO {$this->table} (category_id, name, description, price, size, image, stock) 
                VALUES ($category_id, '$name', '$description', $price, '$size', '$image', $stock)";
        
        // تنفيذ الاستعلام وإرجاع النتيجة (true في حال النجاح)
        return $this->db->query($sql);
    }

    // 5. دالة تعديل بيانات عطر موجود مسبقاً بناءً على الـ ID
    public function update($id, $data) {
        $id          = (int)$id; // تأمين الـ ID
        
        // تنظيف وحماية البيانات الجديدة
        $name        = $this->db->real_escape_string($data['name']);
        $description = $this->db->real_escape_string($data['description']);
        $size        = $this->db->real_escape_string($data['size']);
        $image       = $this->db->real_escape_string($data['image']);
        
        $category_id = (int)$data['category_id'];
        $price       = (float)$data['price'];
        $stock       = (int)$data['stock'];

        // كتابة استعلام التحديث
        $sql = "UPDATE {$this->table} SET 
                category_id = $category_id, 
                name = '$name', 
                description = '$description', 
                price = $price, 
                size = '$size', 
                image = '$image', 
                stock = $stock 
                WHERE id = $id";
        
        return $this->db->query($sql);
    }
}