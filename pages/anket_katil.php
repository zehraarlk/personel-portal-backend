<?php
include "baglan.php";

// Oturum kontrolü
if (empty($_SESSION["personel_id"])) {
    header("Location: login.php");
    exit();
}

$anket_id = (int)($_GET["id"] ?? 0);
$personel_id = (int)$_SESSION["personel_id"];

// Anket geçerlilik doğrulaması
$anket = dbFetchOne($db, "SELECT * FROM anketler WHERE id = ?", [$anket_id]);
if (!$anket) {
    die("Anket bulunamadı.");
}

// Mükerrer katılım kontrolü
$dahaOnceKatildi = dbFetchOne($db, "SELECT id FROM anket_cevaplari WHERE anket_id = ? AND personel_id = ? LIMIT 1", [$anket_id, $personel_id]);

// Eğer daha önce katıldıysa, eski cevaplarını hafızaya alalım
$eskiCevaplar = [];
if ($dahaOnceKatildi) {
    $cevaplarRows = dbFetchAll($db, "SELECT soru_id, secenek_id, cevap_metni FROM anket_cevaplari WHERE anket_id = ? AND personel_id = ?", [$anket_id, $personel_id]);
    foreach ($cevaplarRows as $cr) {
        $eskiCevaplar[$cr["soru_id"]] = [
            "secenek_id" => $cr["secenek_id"],
            "cevap_metni" => $cr["cevap_metni"]
        ];
    }
}

// Soruları ve seçenekleri çekelim
$sorular = dbFetchAll($db, "SELECT * FROM anket_sorulari WHERE anket_id = ? ORDER BY id ASC", [$anket_id]);
foreach ($sorular as $key => $soru) {
    $sorular[$key]["secenekler"] = dbFetchAll($db, "SELECT * FROM anket_secenekleri WHERE soru_id = ? ORDER BY id ASC", [$soru["id"]]);
}

$mesaj = "";

// Form post edildiğinde (Sadece daha önce katılmadıysa çalışır)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($dahaOnceKatildi) {
        die("Bu ankete ait cevaplarınız kilitlenmiştir, tekrar düzenleyemezsiniz.");
    }

    $cevaplar = $_POST["cevap"] ?? [];
    
    $db->beginTransaction();
    try {
        foreach ($sorular as $soru) {
            $soru_id = $soru["id"];
            
            if ($soru["soru_tipi"] === "coktan_secmeli") {
                $secenek_id = (int)($cevaplar[$soru_id] ?? 0);
                if ($secenek_id > 0) {
                    $stmt = $db->prepare("INSERT INTO anket_cevaplari (anket_id, personel_id, soru_id, secenek_id) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$anket_id, $personel_id, $soru_id, $secenek_id]);
                }
            } else {
                $cevap_metni = trim($cevaplar[$soru_id] ?? "");
                if ($cevap_metni !== "") {
                    $stmt = $db->prepare("INSERT INTO anket_cevaplari (anket_id, personel_id, soru_id, cevap_metni) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$anket_id, $personel_id, $soru_id, $cevap_metni]);
                }
            }
        }
        
        // Katılım sayısını güncelle
        $db->prepare("UPDATE anketler SET katilim_sayisi = katilim_sayisi + 1 WHERE id = ?")->execute([$anket_id]);
        
        $db->commit();
        header("Location: anketler.php");
        exit();
    } catch (Exception $e) {
        $db->rollBack();
        $mesaj = "Cevaplar kaydedilirken bir hata oluştu: " . $e->getMessage();
    }
}
?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($anket["baslik"], ENT_QUOTES, "UTF-8") ?> - Ankete Katıl</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .survey-container { max-width: 750px; margin: 40px auto; }
        .question-card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 4px 10px rgba(0,0,0,0.04); margin-bottom: 20px; }
        .disabled-view { opacity: 0.85; pointer-events: none; } /* Seçimleri tıklanamaz yapar */
    </style>
</head>
<body>
<div class="container survey-container">
    
    <?php if ($dahaOnceKatildi): ?>
        <div class="alert alert-warning shadow-sm border-0 d-flex align-items-center gap-3 mb-4">
            <i class="<?= portalSiteIconClass($db, "anket_kilit_acik", "fas fa-lock-open") ?> fa-lg text-warning"></i>
            <div>
                <strong>Sayın Personelimiz;</strong> Bu ankete daha önce katılım sağladınız. Aşağıda vermiş olduğunuz yanıtlar **salt okunur** olarak listelenmektedir, üzerinde değişiklik yapılamaz.
            </div>
        </div>
    <?php endif; ?>

    <div class="card mb-4 shadow-sm border-0 rounded-3">
        <div class="card-body p-4 text-center bg-primary text-white rounded-3">
            <h4><?= htmlspecialchars($anket["baslik"], ENT_QUOTES, "UTF-8") ?></h4>
            <p class="mb-0 text-white-50"><?= htmlspecialchars($anket["aciklama"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
        </div>
    </div>

    <?php if ($mesaj): ?><div class="alert alert-danger"><?= $mesaj ?></div><?php endif; ?>

    <form method="post">
        <?php foreach ($sorular as $i => $soru): 
            $soru_id = $soru["id"];
            $eskiSecenekId = $eskiCevaplar[$soru_id]["secenek_id"] ?? null;
            $eskiMetin = $eskiCevaplar[$soru_id]["cevap_metni"] ?? "";
        ?>
            <div class="question-card <?= $dahaOnceKatildi ? 'disabled-view' : '' ?>">
                <h6>Soru <?= $i + 1 ?>: <?= htmlspecialchars($soru["soru_metni"], ENT_QUOTES, "UTF-8") ?></h6>
                <hr>
                
                <?php if ($soru["soru_tipi"] === "coktan_secmeli"): ?>
                    <?php foreach ($soru["secenekler"] as $sec): 
                        // Eğer personel daha önce bu şıkkı seçtiyse checked yapalım
                        $isChecked = ($eskiSecenekId !== null && (int)$eskiSecenekId === (int)$sec["id"]) ? "checked" : "";
                    ?>
                        <div class="form-check my-2">
                            <input class="form-check-input" type="radio" name="cevap[<?= $soru_id ?>]" id="sec_<?= $sec["id"] ?>" value="<?= $sec["id"] ?>" <?= $isChecked ?> <?= $dahaOnceKatildi ? 'disabled' : '' ?> required>
                            <label class="form-check-label fw-medium text-dark" for="sec_<?= $sec["id"] ?>">
                                <?= htmlspecialchars($sec["secenek_metni"], ENT_QUOTES, "UTF-8") ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="mb-3">
                        <textarea name="cevap[<?= $soru_id ?>]" class="form-control" rows="3" placeholder="Yanıtınızı buraya yazınız..." <?= $dahaOnceKatildi ? 'disabled' : '' ?> required><?= htmlspecialchars($eskiMetin, ENT_QUOTES, "UTF-8") ?></textarea>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <div class="d-flex justify-content-between my-4">
            <a href="anketler.php" class="btn btn-outline-secondary px-4"><i class="<?= portalSiteIconClass($db, "geri_don", "fas fa-arrow-left") ?> me-2"></i> Geri Dön</a>
            <?php if (!$dahaOnceKatildi): ?>
                <button type="submit" class="btn btn-success px-5 fw-bold"><i class="<?= portalSiteIconClass($db, "anket_gonder", "fas fa-paper-plane") ?> me-2"></i>Anketi Tamamla</button>
            <?php endif; ?>
        </div>
    </form>
</div>
</body>
</html>