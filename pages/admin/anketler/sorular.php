<?php
/**
 * Dosya sorumluluğu: Anket sorularını ve seçeneklerini yönetir.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
require_once __DIR__ . "/../includes/auth.php";

$anket_id = (int)($_GET["anket_id"] ?? 0);
$anket = adminFetchAnket($db, $anket_id);

if (!$anket) {
    adminFlashSet("danger", "Anket bulunamadı.");
    header("Location: index.php");
    exit();
}

$currentPage = "anketler";
$pageTitle = "Soruları Yönet: " . $anket["baslik"];
$hata = "";

// Yeni Soru Ekleme
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "soru_ekle") {
    if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
        $hata = "Geçersiz istek.";
    } else {
        $soru_metni = trim($_POST["soru_metni"] ?? "");
        $soru_tipi = trim($_POST["soru_tipi"] ?? "coktan_secmeli");
        
        if ($soru_metni === "") {
            $hata = "Soru metni boş bırakılamaz.";
        } else {
            $nextSira = adminSiraNext($db, "anket_sorulari", $anket_id);
            $stmt = $db->prepare("INSERT INTO anket_sorulari (anket_id, soru_metni, soru_tipi, sira) VALUES (?, ?, ?, ?)");
            $stmt->execute([$anket_id, $soru_metni, $soru_tipi, 0]);
            $newId = (int) $db->lastInsertId();
            adminSiraPlace($db, "anket_sorulari", $newId, $nextSira, $anket_id);
            adminFlashSet("success", "Soru başarıyla eklendi.");
            header("Location: sorular.php?anket_id=" . $anket_id);
            exit();
        }
    }
}

// Seçenek Ekleme
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "secenek_ekle") {
    if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
        $hata = "Geçersiz istek.";
    } else {
        $soru_id = (int)($_POST["soru_id"] ?? 0);
        $secenek_metni = trim($_POST["secenek_metni"] ?? "");
        
        if ($secenek_metni === "") {
            $hata = "Seçenek metni boş bırakılamaz.";
        } else {
            $stmt = $db->prepare("INSERT INTO anket_secenekleri (soru_id, secenek_metni) VALUES (?, ?)");
            $stmt->execute([$soru_id, $secenek_metni]);
            adminFlashSet("success", "Seçenek eklendi.");
            header("Location: sorular.php?anket_id=" . $anket_id);
            exit();
        }
    }
}

// Soru/Seçenek Silme İşlemleri
if (isset($_GET["sil_soru"])) {
    $sil_soru_id = (int)$_GET["sil_soru"];
    $stmt = $db->prepare("DELETE FROM anket_sorulari WHERE id = ? AND anket_id = ?");
    $stmt->execute([$sil_soru_id, $anket_id]);
    adminSiraNormalize($db, "anket_sorulari", $anket_id);
    adminFlashSet("success", "Soru silindi.");
    header("Location: sorular.php?anket_id=" . $anket_id);
    exit();
}

if (isset($_GET["sil_secenek"])) {
    $sil_secenek_id = (int)$_GET["sil_secenek"];
    $stmt = $db->prepare("DELETE FROM anket_secenekleri WHERE id = ?");
    $stmt->execute([$sil_secenek_id]);
    adminFlashSet("success", "Seçenek silindi.");
    header("Location: sorular.php?anket_id=" . $anket_id);
    exit();
}

// Soruları ve şıkları çek
$sorular = dbFetchAll($db, "SELECT * FROM anket_sorulari WHERE anket_id = ? ORDER BY sira ASC, id ASC", [$anket_id]);
foreach ($sorular as $key => $soru) {
    $sorular[$key]["secenekler"] = dbFetchAll($db, "SELECT * FROM anket_secenekleri WHERE soru_id = ? ORDER BY id ASC", [$soru["id"]]);
}

include __DIR__ . "/../includes/header.php";
?>

<div class="row">
    <div class="col-md-4">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5>Yeni Soru Ekle</h5>
            </div>
            <div class="admin-card-body">
                <?php if ($hata): ?><div class="alert alert-danger"><?= htmlspecialchars($hata, ENT_QUOTES, "UTF-8") ?></div><?php endif; ?>
                <form method="post">
                    <input type="hidden" name="action" value="soru_ekle">
                    <input type="hidden" name="csrf" value="<?= htmlspecialchars(adminCsrfToken(), ENT_QUOTES, "UTF-8") ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Soru Metni</label>
                        <textarea name="soru_metni" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Soru Tipi</label>
                        <select name="soru_tipi" class="form-select">
                            <option value="coktan_secmeli">Çoktan Seçmeli</option>
                            <option value="acik_uclu">Açık Uçlu (Metin)</option>
                        </select>
                    </div>
                    <button type="submit" class="admin-btn admin-btn-primary w-100"><i class="fas fa-plus"></i> Soruyu Kaydet</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="admin-card">
            <div class="admin-card-header d-flex justify-content-between align-items-center">
                <h5>Mevcut Sorular</h5>
                <a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-arrow-left"></i> Listeye Dön</a>
            </div>
            <div class="admin-card-body">
                <?php if (empty($sorular)): ?>
                    <p class="text-muted">Bu ankete henüz soru eklenmemiş.</p>
                <?php else: ?>
                    <?php foreach ($sorular as $index => $soru): ?>
                        <div class="card mb-3 shadow-sm border-start border-primary border-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h6>Soru <?= $index + 1 ?>: <?= htmlspecialchars($soru["soru_metni"], ENT_QUOTES, "UTF-8") ?> 
                                        <span class="badge bg-secondary ms-2"><?= $soru["soru_tipi"] === "coktan_secmeli" ? "Çoktan Seçmeli" : "Açık Uçlu" ?></span>
                                    </h6>
                                    <a href="sorular.php?anket_id=<?= $anket_id ?>&sil_soru=<?= $soru["id"] ?>" class="text-danger small" onclick="return confirm('Bu soruyu ve tüm şıklarını silmek istediğinize emin misiniz?');"><i class="fas fa-trash"></i> Soruyu Sil</a>
                                </div>
                                
                                <?php if ($soru["soru_tipi"] === "coktan_secmeli"): ?>
                                    <div class="bg-light p-3 rounded mt-2">
                                        <ul class="list-group list-group-flush mb-2">
                                            <?php foreach ($soru["secenekler"] as $secenek): ?>
                                                <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center py-1 ps-0">
                                                    <span>• <?= htmlspecialchars($secenek["secenek_metni"], ENT_QUOTES, "UTF-8") ?></span>
                                                    <a href="sorular.php?anket_id=<?= $anket_id ?>&sil_secenek=<?= $secenek["id"] ?>" class="text-muted"><i class="fas fa-times-circle"></i></a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                        
                                        <form method="post" class="row g-2 mt-2">
                                            <input type="hidden" name="action" value="secenek_ekle">
                                            <input type="hidden" name="csrf" value="<?= htmlspecialchars(adminCsrfToken(), ENT_QUOTES, "UTF-8") ?>">
                                            <input type="hidden" name="soru_id" value="<?= $soru["id"] ?>">
                                            <div class="col-8">
                                                <input type="text" name="secenek_metni" class="form-control form-control-sm" placeholder="Yeni şık yazın..." required>
                                            </div>
                                            <div class="col-4">
                                                <button type="submit" class="btn btn-success btn-sm w-100"><i class="fas fa-plus"></i> Şık Ekle</button>
                                            </div>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>