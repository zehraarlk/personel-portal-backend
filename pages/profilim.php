<?php
// Bu sayfa artık 3 ayrı sayfaya bölündü:
// email_degistir.php, sifre_degistir.php, oturum_bilgileri.php
// Eski bağlantılar (profilim.php?ref=...) kırılmasın diye buradan yönlendiriyoruz.
session_start();

$ref = $_GET['ref'] ?? '';

switch ($ref) {
    case 'sifre':
        header("Location: sifre_degistir.php");
        break;
    case 'oturum':
        header("Location: oturum_bilgileri.php");
        break;
    case 'email':
    default:
        header("Location: email_degistir.php");
        break;
}
exit;