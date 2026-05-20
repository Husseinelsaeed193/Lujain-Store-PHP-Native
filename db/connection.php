<?php

// db/connection.php
class Database {
    // متغيرات من نوع private لتكون خاصة ومحمية داخل الكلاس
    private $host = "localhost";
    private $root  = "root";
    private $password = "";
    private $DBname ="lujain_store";
    
    // عرفناه public هنا علشان يكون متاح ومكشوف للكلاسات الأخرى بره الملف
    public $conn; 

    public function getConnection(){
        // نبدأ بتصفير المتغير للتأكد من عدم وجود بقايا اتصال قديم
        $this->conn = null;

        try {
            // محاولة الاتصال باستخدام مكتبة mysqli
            $this->conn = new mysqli($this->host, $this->root, $this->password, $this->DBname);
            
            // إذا كان هناك خطأ في الاتصال، ارمي استثناء فوراً ليذهب للـ catch
            if($this->conn->connect_error){
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
            
            // لدعم اللغة العربية بشكل صحيح كامل في المتجر
            $this->conn->set_charset("utf8mb4");
            
        } catch (Exception $e) {
            // قسم الطوارئ: إذا فشل الاتصال، اطبع رسالة الخطأ ولا توقف السيرفر بالكامل
            echo "خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage();
        }
        
        // السطر الأهم: إرجاع كائن الاتصال الفعلي للاستخدام في بقية المشروع
        return $this->conn;
    }
}