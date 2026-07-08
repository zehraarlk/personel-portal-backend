<?php
session_start();
include("baglan.php");

// Kalıcı oturum cookie/token temizle
$pid = isset($_SESSION["personel_id"]) ? (int)$_SESSION["personel_id"] : null;
authClearRememberToken($db, $pid);

if (isset($_SESSION['oturum_id'])) {
    $oturum_id = $_SESSION['oturum_id'];
    
    // 🕒 Çıkış yapılan zamanı veritabanına işliyoruz
    $cikis_guncelle = $db->prepare("UPDATE oturum_kayitlari SET cikis_zamani = NOW() WHERE id = ?");
    $cikis_guncelle->execute([$oturum_id]);
}

// Bütün seansları temizle ve giriş sayfasına yönlendir
session_destroy();
header("Location: login.php");
exit;