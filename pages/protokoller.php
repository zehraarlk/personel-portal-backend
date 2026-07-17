<?php
/**
 * Dosya sorumluluğu: Protokol kaynakları sayfası.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
declare(strict_types=1);

$pageTitle = 'Protokoller';
$kaynakActiveKey = 'protocol';
$kaynakSlug = 'Protokoller';
$kaynakSearchPlaceholder = 'Protokol ara...';
$kaynakEmptyText = 'Henüz eklenmiş protokol bulunmuyor.';
$kaynakIntro = 'İlgili birimlerle yapılan tüm protokolleri görüntüleyebilir, detaylarına ulaşabilirsiniz.';

require __DIR__ . '/../includes/kaynaklar-page.php';
