<?php
// Veritabanı bağlantı bilgileri
$host     = "localhost";
$db_name  = "personel_db"; // phpMyAdmin'de açtığımız ortak veritabanı adı
$username = "root";        // XAMPP standart kullanıcı adı
$password = "";            // XAMPP standart şifresi boştur

try {
    // PDO köprüsünü kuruyoruz ve Türkçe karakter ayarını (UTF8) yapıyoruz
    $db = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $username, $password);
    
    // Hata yönetimini aktif ediyoruz (Bir hata olursa bize açıkça söylesin diye)
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Bağlantı başarılıysa şimdilik arkada sessizce çalışsın
} catch (PDOException $e) {
    // Eğer bağlantı kurulamazsa hatayı ekrana basıp sistemi durdurur
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>