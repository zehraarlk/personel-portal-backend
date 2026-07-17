<?php
/**
 * Dosya sorumluluğu: Mevzuat kaynakları sayfası.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
declare(strict_types=1);

$pageTitle = 'Mevzuatlar';
$kaynakActiveKey = 'regulation';
$kaynakSlug = 'Mevzuatlar';
$kaynakSearchPlaceholder = 'Mevzuat ara...';
$kaynakEmptyText = 'Henüz eklenmiş mevzuat bulunmuyor.';
$kaynakIntro = 'Personeli ilgilendiren yasal düzenleme ve mevzuatlara buradan ulaşabilirsiniz.';

require __DIR__ . '/../includes/kaynaklar-page.php';
