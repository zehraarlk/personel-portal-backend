<?php
declare(strict_types=1);

require_once __DIR__ . '/icons.php';

$navItems = [
    [
        'type' => 'link',
        'label' => 'Ana Sayfa',
        'href' => $assetBase . 'pages/ana_sayfa.php',
        'active' => isHomePage(),
    ],
    [
        'type' => 'link',
        'label' => 'Videolar',
        'href' => $assetBase . 'pages/videolar.php',
        'active' => isNavActive('videolar'),
    ],
    [
        'type' => 'dropdown',
        'label' => 'Etkinlikler',
        'active' => isNavActive('sizden_gelenler') || isNavActive('etkinlikler') || isNavActive('duyurular'),
        'items' => [
            ['href' => $assetBase . 'pages/sizden_gelenler.php', 'icon' => 'sizden_gelenler', 'title' => 'Sizden Gelenler', 'desc' => 'Personelden gelen paylaşımlar'],
            ['href' => $assetBase . 'pages/etkinlikler.php', 'icon' => 'etkinlikler', 'title' => 'Etkinlikler', 'desc' => 'Kurumsal etkinlik takvimi'],
            ['href' => $assetBase . 'pages/duyurular.php', 'icon' => 'duyurular', 'title' => 'Duyurular', 'desc' => 'Güncel kurum duyuruları'],
        ],
    ],
    [
        'type' => 'dropdown',
        'label' => 'Kaynaklar',
        'active' => isNavActive('protokoller') || isNavActive('dokumanlar') || isNavActive('mevzuatlar') || isNavActive('egitimler'),
        'items' => [
            ['href' => $assetBase . 'pages/protokoller.php', 'icon' => 'protokoller', 'title' => 'Protokoller', 'desc' => 'Kurumsal protokol belgeleri'],
            ['href' => $assetBase . 'pages/dokumanlar.php', 'icon' => 'dokumanlar', 'title' => 'Dokümanlar', 'desc' => 'Formlar ve yönergeler'],
            ['href' => $assetBase . 'pages/mevzuatlar.php', 'icon' => 'mevzuatlar', 'title' => 'Mevzuatlar', 'desc' => 'Yasal düzenlemeler ve mevzuat'],
            ['href' => $assetBase . 'pages/egitimler.php', 'icon' => 'egitimler', 'title' => 'Eğitimler', 'desc' => 'Eğitim materyalleri ve içerikler'],
        ],
    ],
    [
        'type' => 'dropdown',
        'label' => 'Diğer',
        'active' => isNavActive('anketler') || isNavActive('yardimci_linkler') || isNavActive('vefat_bilgisi') || isNavActive('dogum_gunu'),
        'items' => [
            ['href' => $assetBase . 'pages/anketler.php', 'icon' => 'anketler', 'title' => 'Anketler', 'desc' => 'Aktif ve geçmiş anketler'],
            ['href' => $assetBase . 'pages/yardimci_linkler.php', 'icon' => 'yardimci_linkler', 'title' => 'Yardımcı Linkler', 'desc' => 'Faydalı kurumsal bağlantılar'],
            ['href' => $assetBase . 'pages/vefat_bilgisi.php', 'icon' => 'vefat_bilgisi', 'title' => 'Vefat Eden Bilgisi', 'desc' => 'Vefat ve taziye duyuruları'],
            ['href' => $assetBase . 'pages/dogum_gunu.php', 'icon' => 'dogum_gunu', 'title' => 'Doğum Günü Bilgisi', 'desc' => 'Personel doğum günü listesi'],
        ],
    ],
];

?>
<header class="navbar" role="banner">
    <div class="site-container">
        <!-- Sol: Logo -->
        <a href="<?= e($assetBase) ?>pages/ana_sayfa.php" class="navbar-brand" aria-label="Gebze Belediyesi — Ana Sayfa">
            <img src="<?= e(logoUrl($assetBase)) ?>" alt="Gebze Belediyesi Logosu" width="260" height="56">
        </a>

        <!-- Orta: Menü -->
        <nav class="navbar-center" aria-label="Ana menü">
            <?php foreach ($navItems as $item): ?>
                <?php if ($item['type'] === 'link'): ?>
                <a href="<?= e($item['href']) ?>"
                   class="nav-link<?= $item['active'] ? ' is-active' : '' ?>">
                    <?= e($item['label']) ?>
                </a>
                <?php else: ?>
                <div class="nav-item" data-dropdown>
                    <button type="button"
                            class="nav-link<?= $item['active'] ? ' is-active' : '' ?>"
                            aria-expanded="false"
                            aria-haspopup="true">
                        <?= e($item['label']) ?>
                        <span class="chevron icon" aria-hidden="true"><?= icon('chevron-down') ?></span>
                    </button>
                    <div class="nav-dropdown-menu" role="menu">
                        <div class="dropdown-list">
                            <?php foreach ($item['items'] as $sub): ?>
                            <a href="<?= e($sub['href']) ?>" class="dropdown-link" role="menuitem">
                                <span class="icon" aria-hidden="true"><?= icon($sub['icon']) ?></span>
                                <span class="dropdown-link-text">
                                    <strong><?= e($sub['title']) ?></strong>
                                    <span><?= e($sub['desc']) ?></span>
                                </span>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </nav>

        <!-- Sağ: Profil -->
        <div class="navbar-end">
            <div class="profile-dropdown" data-profile-dropdown>
                <button type="button" class="profile-trigger" aria-expanded="false" aria-haspopup="true">
                    <img src="<?= e($userPhoto) ?>" alt="" class="profile-avatar profile-avatar-img profile-avatar--brand" width="38" height="38">
                    <span class="profile-info">
                        <span class="profile-name"><?= e($userName) ?></span>
                        <span class="profile-role profile-role--<?= e($userType) ?>"><?= e($userTitle) ?></span>
                    </span>
                    <span class="chevron icon" aria-hidden="true"><?= icon('chevron-down') ?></span>
                </button>

                <div class="profile-menu" role="menu">
                    <?php if (($userType ?? '') === 'yonetici'): ?>
                    <a href="<?= e($assetBase) ?>pages/admin/index.php" role="menuitem">
                        <span class="icon" aria-hidden="true"><?= icon('yonetim_paneli') ?></span>
                        Yönetim Paneli
                    </a>
                    <a href="<?= e($assetBase) ?>pages/profil/oturum.php" role="menuitem">
                        <span class="icon" aria-hidden="true"><?= icon('oturum_bilgileri') ?></span>
                        Oturum Bilgileri
                    </a>
                    <?php else: ?>
                    <a href="<?= e($assetBase) ?>pages/profil/email.php" role="menuitem">
                        <span class="icon" aria-hidden="true"><?= icon('email_degistir') ?></span>
                        E-posta Değiştir
                    </a>
                    <a href="<?= e($assetBase) ?>pages/profil/sifre.php" role="menuitem">
                        <span class="icon" aria-hidden="true"><?= icon('sifre_degistir') ?></span>
                        Şifre Değiştir
                    </a>
                    <a href="<?= e($assetBase) ?>pages/profil/oturum.php" role="menuitem">
                        <span class="icon" aria-hidden="true"><?= icon('oturum_bilgileri') ?></span>
                        Oturum Bilgileri
                    </a>
                    <?php endif; ?>
                    <div class="divider" role="separator"></div>
                    <a href="<?= e($assetBase) ?>pages/cikis.php" class="logout-link" role="menuitem">
                        <span class="icon" aria-hidden="true"><?= icon('cikis_yap') ?></span>
                        Çıkış Yap
                    </a>
                </div>
            </div>

            <button type="button" class="hamburger-btn" data-menu-toggle aria-label="Menüyü aç" aria-expanded="false">
                <span class="hamburger-icon hamburger-icon-open" aria-hidden="true"><?= icon('menu_ac') ?></span>
                <span class="hamburger-icon hamburger-icon-close" aria-hidden="true"><?= icon('menu-close') ?></span>
            </button>
        </div>
    </div>
</header>

<!-- Mobil menü -->
<div class="menu-backdrop" data-menu-backdrop aria-hidden="true"></div>
<aside class="side-menu" data-side-menu aria-label="Mobil menü" aria-hidden="true">
    <div class="side-menu-header">
        <img src="<?= e(logoUrl($assetBase)) ?>" alt="Gebze Belediyesi Logosu" height="40">
        <button type="button" class="side-menu-close" data-menu-close aria-label="Menüyü kapat">
            <span class="icon" aria-hidden="true"><?= icon('close') ?></span>
        </button>
    </div>

    <?php foreach ($navItems as $item): ?>
        <?php if ($item['type'] === 'link'): ?>
        <a href="<?= e($item['href']) ?>"
           class="side-menu-link<?= $item['active'] ? ' is-active' : '' ?>">
            <?= e($item['label']) ?>
        </a>
        <?php else: ?>
        <p class="side-menu-group-title"><?= e($item['label']) ?></p>
            <?php foreach ($item['items'] as $sub): ?>
            <a href="<?= e($sub['href']) ?>" class="side-menu-link">
                <span class="icon" aria-hidden="true"><?= icon($sub['icon']) ?></span>
                <?= e($sub['title']) ?>
            </a>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>

    <p class="side-menu-group-title">Profil</p>
    <?php if (($userType ?? '') === 'yonetici'): ?>
    <a href="<?= e($assetBase) ?>pages/admin/index.php" class="side-menu-link">
        <span class="icon" aria-hidden="true"><?= icon('yonetim_paneli') ?></span>
        Yönetim Paneli
    </a>
    <a href="<?= e($assetBase) ?>pages/profil/oturum.php" class="side-menu-link">
        <span class="icon" aria-hidden="true"><?= icon('oturum_bilgileri') ?></span>
        Oturum Bilgileri
    </a>
    <?php else: ?>
    <a href="<?= e($assetBase) ?>pages/profil/email.php" class="side-menu-link">
        <span class="icon" aria-hidden="true"><?= icon('email_degistir') ?></span>
        E-posta Değiştir
    </a>
    <a href="<?= e($assetBase) ?>pages/profil/sifre.php" class="side-menu-link">
        <span class="icon" aria-hidden="true"><?= icon('sifre_degistir') ?></span>
        Şifre Değiştir
    </a>
    <a href="<?= e($assetBase) ?>pages/profil/oturum.php" class="side-menu-link">
        <span class="icon" aria-hidden="true"><?= icon('oturum_bilgileri') ?></span>
        Oturum Bilgileri
    </a>
    <?php endif; ?>
    <a href="<?= e($assetBase) ?>pages/cikis.php" class="side-menu-link">
        <span class="icon" aria-hidden="true"><?= icon('cikis_yap') ?></span>
        Çıkış Yap
    </a>
</aside>
