<?php
/**
 * Dosya sorumluluğu: Uygulama yapılandırma sabitleri.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
/**
 * Uygulama sabitleri (site adı, logo yolları, veritabanı, iletişim).
 * Tüm sayfalar dolaylı olarak bu dosyayı kullanır.
 */
declare(strict_types=1);

/** Tarayıcı sekmesi ve e-posta başlıklarında görünen resmi site adı. */
define('SITE_NAME', 'Gebze Personel Portalı');

/** Proje kök dizini (config/ bir üst). */
define('PROJECT_ROOT', dirname(__DIR__));

/** Kamu sitesi logo / favicon yolları (images/ altından). */
define('SITE_LOGO', 'images/logo(2).webp');
define('SITE_FAVICON', 'images/favicon.webp');

/** Giriş ekranı arka planı (yerel) ve CDN logo URL’si. */
define('LOGIN_LOGO', 'images/login/login.jpg');
define('LOGIN_LOGO_URL', 'https://personel.gebze.bel.tr/public/img/logo/logo1.png');
define('IMAGES_DIR', PROJECT_ROOT . '/images');

/** MySQL bağlantı bilgileri — production’da şifreyi boş bırakmayın. */
define('DB_HOST', 'localhost');
define('DB_NAME', 'personel_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

/** Footer iletişim bilgileri. */
define('FOOTER_PHONE', '(0262) 123 45 67');
define('FOOTER_PHONE_LINK', '02621234567');
define('FOOTER_EMAIL', 'bilgiislem@gebze.bel.tr');

/** Sosyal medya bağlantıları (footer). */
define('SOCIAL_FACEBOOK', 'https://www.facebook.com/gebzebelediye');
define('SOCIAL_TWITTER', 'https://x.com/gebze_belediye');
define('SOCIAL_INSTAGRAM', 'https://www.instagram.com/gebze_belediyesi/?hl=tr');
define('SOCIAL_YOUTUBE', 'https://www.youtube.com/@gebzebelediyesi7295');
define('SOCIAL_LINKEDIN', 'https://www.linkedin.com/company/gebze-belediyesi');
