<?php
require_once __DIR__ . "/includes/auth.php";

$currentPage = "dashboard";
$pageTitle = "Dashboard";

$yonetimStats = [
  [
    "label" => "Personeller",
    "value" => adminCountTable($db, "personeller"),
    "icon" => "fa-users",
    "color" => "purple",
    "href" => "personeller/index.php",
  ],
  [
    "label" => "Yöneticiler",
    "value" => adminCountTable($db, "yoneticiler"),
    "icon" => "fa-user-shield",
    "color" => "orange",
    "href" => "yoneticiler/index.php",
  ],
];

$icerikStats = [
  [
    "label" => "Videolar",
    "value" => adminCountTable($db, "videolar"),
    "icon" => "fa-video",
    "color" => "purple",
    "href" => "videolar/index.php",
  ],
  [
    "label" => "Duyurular",
    "value" => count(adminFetchDuyurular($db)),
    "icon" => "fa-bullhorn",
    "color" => "blue",
    "href" => "duyurular/index.php",
  ],
  [
    "label" => "Etkinlikler",
    "value" => adminCountTable($db, "etkinlikler"),
    "icon" => "fa-calendar-days",
    "color" => "green",
    "href" => "etkinlikler/index.php",
  ],
  [
    "label" => "Sizden Gelenler",
    "value" => adminCountTable($db, "sizden_gelenler"),
    "icon" => "fa-comments",
    "color" => "orange",
    "href" => "sizden_gelenler/index.php",
  ],
  [
    "label" => "Anketler",
    "value" => adminCountTable($db, "anketler"),
    "icon" => "fa-poll",
    "color" => "blue",
    "href" => "anketler/index.php",
  ],
  [
    "label" => "Yardımcı Linkler",
    "value" => adminCountTable($db, "yardimci_linkler"),
    "icon" => "fa-link",
    "color" => "orange",
    "href" => "yardimci_linkler/index.php",
  ],
  [
    "label" => "Vefat Kayıtları",
    "value" => adminCountTable($db, "vefat_bilgileri"),
    "icon" => "fa-heart",
    "color" => "purple",
    "href" => "vefat_bilgileri/index.php",
  ],
  [
    "label" => "Kaynaklar",
    "value" => adminCountTable($db, "kaynaklar"),
    "icon" => "fa-folder-open",
    "color" => "green",
    "href" => "kaynaklar/index.php",
  ],
  [
    "label" => "Site İkonları",
    "value" => adminCountTable($db, "site_ikonlari"),
    "icon" => "fa-icons",
    "color" => "purple",
    "href" => "site_ikonlari/index.php",
  ],
];

$sonVideolar = dbFetchAll(
  $db,
  "SELECT id, baslik, sure, youtube_id FROM videolar ORDER BY id DESC LIMIT 5",
);

if (isset($_GET["hata"]) && $_GET["hata"] === "yetkisiz") {
  adminFlashSet("warning", "Bu işlem için yetkiniz bulunmuyor.");
}

include __DIR__ . "/includes/header.php";

$renderStatCards = static function (array $stats): void {
  foreach ($stats as $stat): ?>
  <a href="<?= htmlspecialchars((string) ($stat["href"] ?? "#"), ENT_QUOTES, "UTF-8") ?>" class="admin-stat-card">
    <div class="icon <?= htmlspecialchars($stat["color"], ENT_QUOTES, "UTF-8") ?>">
      <i class="fas <?= htmlspecialchars($stat["icon"], ENT_QUOTES, "UTF-8") ?>"></i>
    </div>
    <div class="value"><?= (int) $stat["value"] ?></div>
    <div class="label"><?= htmlspecialchars($stat["label"], ENT_QUOTES, "UTF-8") ?></div>
  </a>
  <?php endforeach;
};
?>

<section class="admin-stats-block">
  <h2 class="admin-stats-title">Personel ve Yönetici</h2>
  <div class="admin-stats admin-stats--compact">
    <?php $renderStatCards($yonetimStats); ?>
  </div>
</section>

<section class="admin-stats-block">
  <h2 class="admin-stats-title">İçerik Yönetimi</h2>
  <div class="admin-stats">
    <?php $renderStatCards($icerikStats); ?>
  </div>
</section>

<div class="admin-dashboard-split">
  <div class="admin-card">
    <div class="admin-card-header">
      <h3><i class="fas fa-bolt me-2 text-warning"></i>Hızlı İşlemler</h3>
    </div>
    <div class="admin-card-body">
      <div class="admin-quick-links">
        <a href="personeller/ekle.php" class="admin-quick-link"><i class="fas fa-user-plus"></i><div><strong>Personel Ekle</strong><div class="text-muted small">Yeni personel kaydı</div></div></a>
        <a href="yoneticiler/ekle.php" class="admin-quick-link"><i class="fas fa-user-shield"></i><div><strong>Yönetici Ekle</strong><div class="text-muted small">Yeni yönetici kaydı</div></div></a>
        <a href="videolar/ekle.php" class="admin-quick-link"><i class="fas fa-video"></i><div><strong>Yeni Video</strong><div class="text-muted small">YouTube ID ile</div></div></a>
        <a href="duyurular/ekle.php" class="admin-quick-link"><i class="fas fa-bullhorn"></i><div><strong>Yeni Duyuru</strong><div class="text-muted small">Duyuru ekle</div></div></a>
        <a href="etkinlikler/ekle.php" class="admin-quick-link"><i class="fas fa-calendar-plus"></i><div><strong>Yeni Etkinlik</strong><div class="text-muted small">Etkinlik ekle</div></div></a>
        <a href="sizden_gelenler/ekle.php" class="admin-quick-link"><i class="fas fa-comments"></i><div><strong>Sizden Gelen</strong><div class="text-muted small">Yeni paylaşım</div></div></a>
        <a href="anketler/ekle.php" class="admin-quick-link"><i class="fas fa-poll"></i><div><strong>Yeni Anket</strong><div class="text-muted small">Anket oluştur</div></div></a>
        <a href="yardimci_linkler/ekle.php" class="admin-quick-link"><i class="fas fa-link"></i><div><strong>Yardımcı Link</strong><div class="text-muted small">Yeni link ekle</div></div></a>
        <a href="vefat_bilgileri/ekle.php" class="admin-quick-link"><i class="fas fa-heart"></i><div><strong>Vefat Kaydı</strong><div class="text-muted small">Yeni kayıt</div></div></a>
        <a href="kaynaklar/ekle.php" class="admin-quick-link"><i class="fas fa-folder-plus"></i><div><strong>Yeni Kaynak</strong><div class="text-muted small">Protokol, döküman...</div></div></a>
        <a href="site_ikonlari/ekle.php" class="admin-quick-link"><i class="fas fa-icons"></i><div><strong>Site İkonu</strong><div class="text-muted small">Yeni ikon ekle</div></div></a>
      </div>
    </div>
  </div>

  <div class="admin-card">
    <div class="admin-card-header">
      <h3><i class="fas fa-clock me-2"></i>Son Videolar</h3>
      <a href="videolar/index.php" class="admin-btn admin-btn-secondary admin-btn-sm">Tümü</a>
    </div>
    <div class="admin-card-body p-0">
      <?php if (empty($sonVideolar)): ?>
        <p class="text-muted p-3 mb-0">Henüz video eklenmemiş.</p>
      <?php else: ?>
      <div class="admin-table-wrap">
        <table class="admin-table mb-0">
          <tbody>
            <?php foreach ($sonVideolar as $video): ?>
            <tr>
              <td>
                <strong><?= htmlspecialchars(
                  mb_strimwidth($video["baslik"], 0, 40, "..."),
                  ENT_QUOTES,
                  "UTF-8",
                ) ?></strong>
                <div class="text-muted small"><?= htmlspecialchars(
                  $video["sure"],
                  ENT_QUOTES,
                  "UTF-8",
                ) ?></div>
              </td>
              <td class="text-end">
                <a href="videolar/duzenle.php?id=<?= (int) $video[
                  "id"
                ] ?>" class="admin-btn admin-btn-secondary admin-btn-sm">
                  <i class="fas fa-pen"></i>
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include __DIR__ . "/includes/footer.php"; ?>
