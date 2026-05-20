<?php
// src/Classes/Model.php
//هذا الكلاس هو أهم قطعة في هيكلة الـ OOP لمتجرنا؛ فهو الكلاس "المشترك" الذي سيوفر على كلاسات الأبناء (Products, Users, Categories) إعادة كتابة استعلامات قاعدة البيانات المتكررة مثل الجلب والحذف.

abstract class Model {
    // متغيرات محميّة (Protected) لكي تتوفر للأبناء فقط ولا تراها الملفات الخارجية
    protected $db;    // سيخزن كائن الاتصال الفعلي بقاعدة البيانات
    protected $table; // سيحدد اسم الجدول الخاص بكل ابن (مثلاً: products أو users)

    // الـ Constructor: يستقبل الاتصال المفتوح عند إنشاء كائن من الابن
    public function __construct($db_connection) {
        $this->db = $db_connection;
    }

    // 1. دالة جلب كل البيانات من الجدول
    public function getAll() {
        $sql = "SELECT * FROM {$this->table}";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // 2. دالة جلب عنصر واحد فقط بناءً على الـ ID
    public function getById($id) {
        // حماية الـ ID وتنظيفه قبل وضعه في الاستعلام
        $id = $this->db->real_escape_string($id);
        
        $sql = "SELECT * FROM {$this->table} WHERE id = $id";
        $result = $this->db->query($sql);
        return $result->fetch_assoc();
    }

    // 3. دالة حذف عنصر من الجدول بناءً على الـ ID
    public function delete($id) {
        $id = $this->db->real_escape_string($id);
        
        $sql = "DELETE FROM {$this->table} WHERE id = $id";
        return $this->db->query($sql);
    }
}