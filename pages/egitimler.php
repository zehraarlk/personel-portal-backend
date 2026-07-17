<?php
/**
 * Dosya sorumluluğu: Eğitim kaynakları sayfası.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
declare(strict_types=1);

$pageTitle = 'Eğitimler';
$kaynakActiveKey = 'training';
$kaynakSlug = 'Eğitimler';
$kaynakSearchPlaceholder = 'Eğitim ara...';
$kaynakEmptyText = 'Henüz eklenmiş eğitim içeriği bulunmuyor.';
$kaynakIntro = 'Eğitim materyalleri ve videolara buradan ulaşabilirsiniz.';

require __DIR__ . '/../includes/kaynaklar-page.php';
