<?php

// db/connection.php
class Database {
// متغيرات من نوع privet  لتكون خاصه
private $host = "localhost";
private $root  = "root";
private $password = "";
private $DBname ="lujain_store";
public $conn; //عرفناه هنا علشان يكون متاح لكل الدوال فى الكلاس

public function getConnection(){
    $this->conn=null;// نبدأ بتصفير المتغير للتأكد من عدم وجود بقايا اتصال قديم.

    try{
        //بداية محاولة الاتصال: الـ try تشبه قولك لـ PHP: "حاول تنفيذ الكود التالي، وإذا حدثت مشكلة لا تنهار وتوقف البرنامج، بل اذهب لقسم الطوارئ (catch)".
      $this->conn = new  mysqli($this->host,$this->root,$this->password,$this->DBname);
      if($this->conn->connect_error){
        throw new Exception("Connection failed: " . $this->conn->connect_error);
      }
      $this->conn->set_charset("utf8mb4");
    }catch{
        
    }
    
}




}