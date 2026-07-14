<?php
<<<<<<< HEAD
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/icons.php';

$personelId = currentAnketPersonelId();

if ($personelId <= 0) {
    header('Location: ' . $assetBase . 'pages/login.php', true, 302);
    exit;
}

$anketId = (int) ($_GET['id'] ?? 0);
$pdo = getPDO();
dbEnsureAnketKatilimlari($pdo);
$flashError = '';
$flashSuccess = '';
$anket = null;
$sorular = [];
$eskiCevaplar = [];
$dahaOnceKatildi = false;

if ($anketId <= 0 || !dbTableExists($pdo, 'anketler')) {
    header('Location: ' . $assetBase . 'pages/anketler.php', true, 302);
    exit;
}

try {
    $anket = dbFetchOne($pdo, 'SELECT * FROM anketler WHERE id = ?', [$anketId]);
} catch (Throwable) {
    $anket = null;
}

if (!$anket) {
    header('Location: ' . $assetBase . 'pages/anketler.php', true, 302);
    exit;
}

$pageTitle = (string) ($anket['baslik'] ?? 'Anket');
$pageCss = 'anketler.css';
$showBreadcrumb = true;

$dahaOnceKatildi = personelAnketKatildiMi($pdo, $anketId, $personelId);

if ($dahaOnceKatildi && dbTableExists($pdo, 'anket_cevaplari')) {
    try {
        $rows = dbFetchAll(
            $pdo,
            'SELECT soru_id, secenek_id, cevap_metni FROM anket_cevaplari WHERE anket_id = ? AND personel_id = ?',
            [$anketId, $personelId]
        );
        foreach ($rows as $row) {
            $eskiCevaplar[(int) $row['soru_id']] = [
                'secenek_id' => $row['secenek_id'] ?? null,
                'cevap_metni' => (string) ($row['cevap_metni'] ?? ''),
            ];
        }
    } catch (Throwable) {
        // salt okunur görünüm boş kalabilir
    }
}

if (dbTableExists($pdo, 'anket_sorulari')) {
    try {
        $sorular = dbFetchAll(
            $pdo,
            'SELECT * FROM anket_sorulari WHERE anket_id = ? ORDER BY sira ASC, id ASC',
            [$anketId]
        );

        foreach ($sorular as $key => $soru) {
            $sorular[$key]['secenekler'] = [];
            if (dbTableExists($pdo, 'anket_secenekleri')) {
                $sorular[$key]['secenekler'] = dbFetchAll(
                    $pdo,
                    'SELECT * FROM anket_secenekleri WHERE soru_id = ? ORDER BY id ASC',
                    [(int) $soru['id']]
                );
            }
        }
    } catch (Throwable) {
        $sorular = [];
    }
}

$soruSayisi = count($sorular);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $personelId = currentAnketPersonelId();
    if ($personelId <= 0) {
        header('Location: ' . $assetBase . 'pages/login.php', true, 302);
        exit;
    }

    $cevaplarPost = is_array($_POST['cevap'] ?? null) ? $_POST['cevap'] : [];

    // Hata olsa bile işaretlenenleri geri göster
    $preservePostedCevaplar = static function (array $sorular, array $cevaplarPost): array {
        $out = [];
        foreach ($sorular as $soru) {
            $soruId = (int) ($soru['id'] ?? 0);
            if ($soruId <= 0) {
                continue;
            }
            $tip = (string) ($soru['soru_tipi'] ?? '');
            if ($tip === 'coktan_secmeli') {
                $opt = (int) ($cevaplarPost[$soruId] ?? 0);
                if ($opt > 0) {
                    $out[$soruId] = ['secenek_id' => $opt, 'cevap_metni' => ''];
                }
            } else {
                $metin = trim((string) ($cevaplarPost[$soruId] ?? ''));
                if ($metin !== '') {
                    $out[$soruId] = ['secenek_id' => null, 'cevap_metni' => $metin];
                }
            }
        }
        return $out;
    };

    if (!csrfVerify($_POST['csrf_token'] ?? null)) {
        $flashError = 'Geçersiz güvenlik doğrulaması.';
        $eskiCevaplar = $preservePostedCevaplar($sorular, $cevaplarPost);
    } elseif (personelAnketKatildiMi($pdo, $anketId, $personelId)) {
        $flashError = 'Bu ankete ait cevaplarınız kilitlenmiştir, tekrar düzenleyemezsiniz.';
        $dahaOnceKatildi = true;
    } elseif ($sorular === []) {
        $flashError = 'Bu ankete henüz soru eklenmemiş.';
    } elseif (!dbTableExists($pdo, 'anket_cevaplari')) {
        $flashError = 'Anket cevap tablosu henüz hazır değil.';
    } else {
        $cevaplar = $cevaplarPost;
        $eksik = false;
        $hazirSatirlar = [];

        foreach ($sorular as $soru) {
            $soruId = (int) $soru['id'];
            $tip = (string) ($soru['soru_tipi'] ?? '');

            if ($tip === 'coktan_secmeli') {
                $secenekId = (int) ($cevaplar[$soruId] ?? 0);
                if ($secenekId <= 0) {
                    $eksik = true;
                    break;
                }
                $hazirSatirlar[] = ['tip' => 'secenek', 'soru_id' => $soruId, 'secenek_id' => $secenekId];
            } else {
                $metin = trim((string) ($cevaplar[$soruId] ?? ''));
                if ($metin === '') {
                    $eksik = true;
                    break;
                }
                $hazirSatirlar[] = ['tip' => 'metin', 'soru_id' => $soruId, 'metin' => $metin];
            }
        }

        if ($eksik) {
            $flashError = 'Lütfen tüm soruları yanıtlayın.';
            $eskiCevaplar = $preservePostedCevaplar($sorular, $cevaplarPost);
        } else {
            try {
                $pdo->beginTransaction();

                $insSec = $pdo->prepare(
                    'INSERT INTO anket_cevaplari (anket_id, personel_id, soru_id, secenek_id) VALUES (?, ?, ?, ?)'
                );
                $insMet = $pdo->prepare(
                    'INSERT INTO anket_cevaplari (anket_id, personel_id, soru_id, cevap_metni) VALUES (?, ?, ?, ?)'
                );

                foreach ($hazirSatirlar as $satir) {
                    if ($satir['tip'] === 'secenek') {
                        $insSec->execute([$anketId, $personelId, $satir['soru_id'], $satir['secenek_id']]);
                    } else {
                        $insMet->execute([$anketId, $personelId, $satir['soru_id'], $satir['metin']]);
                    }
                }

                $pdo->prepare(
                    'INSERT IGNORE INTO anket_katilimlari (anket_id, personel_id) VALUES (?, ?)'
                )->execute([$anketId, $personelId]);

                $countRow = dbFetchOne(
                    $pdo,
                    'SELECT COUNT(*) AS c FROM anket_katilimlari WHERE anket_id = ?',
                    [$anketId]
                );
                $pdo->prepare('UPDATE anketler SET katilim_sayisi = ? WHERE id = ?')
                    ->execute([(int) ($countRow['c'] ?? 0), $anketId]);

                $pdo->commit();

                $_SESSION['anket_katilim_ok'] = (string) ($anket['baslik'] ?? 'Anket');
                header('Location: ' . $assetBase . 'pages/anketler.php', true, 302);
                exit;
            } catch (Throwable $e) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                error_log('Anket katilim hatasi: ' . $e->getMessage());
                $flashError = 'Cevaplar kaydedilirken bir hata oluştu.';
                $eskiCevaplar = $preservePostedCevaplar($sorular, $cevaplarPost);
            }
        }
    }
}

require __DIR__ . '/../includes/site-head.php';
require __DIR__ . '/../includes/header-nav.php';
require __DIR__ . '/../includes/breadcrumb.php';
?>

<main class="content-area anketler-page anket-katil-page">
    <div class="site-container">
        <div class="ak-join-wrap">
            <?php if ($dahaOnceKatildi): ?>
            <p class="ak-join-alert" role="status">
                <span class="icon" aria-hidden="true"><?= icon('anketler') ?></span>
                Bu ankete daha önce katıldınız. Yanıtlarınız salt okunur olarak görüntüleniyor.
            </p>
            <?php endif; ?>

            <?php if ($flashError !== ''): ?>
            <p class="ak-join-error" role="alert"><?= e($flashError) ?></p>
            <?php endif; ?>

            <header class="ak-join-hero">
                <div class="ak-join-hero-icon" aria-hidden="true">
                    <span class="icon"><?= icon('anketler') ?></span>
                </div>
                <div class="ak-join-hero-copy">
                    <p class="ak-join-kicker">Ankete Katıl</p>
                    <h1><?= e((string) ($anket['baslik'] ?? '')) ?></h1>
                    <?php if (!empty($anket['aciklama'])): ?>
                    <p class="ak-join-desc"><?= e((string) $anket['aciklama']) ?></p>
                    <?php endif; ?>
                </div>
                <?php if ($soruSayisi > 0): ?>
                <div class="ak-join-stat" aria-label="Soru sayısı">
                    <span class="ak-join-stat-value"><?= $soruSayisi ?></span>
                    <span class="ak-join-stat-label">soru</span>
                </div>
                <?php endif; ?>
            </header>

            <?php if ($sorular === []): ?>
            <div class="ak-empty">
                <span class="icon" aria-hidden="true"><?= icon('anketler') ?></span>
                <h2>Soru Bulunamadı</h2>
                <p>Bu ankete henüz soru eklenmemiş. Daha sonra tekrar deneyin.</p>
                <a class="ak-btn" href="<?= e($assetBase) ?>pages/anketler.php">
                    <span class="icon" aria-hidden="true"><?= icon('geri_don') ?></span>
                    Anketlere Dön
                </a>
            </div>
            <?php else: ?>
            <form method="post" class="ak-join-form<?= $dahaOnceKatildi ? ' is-readonly' : '' ?>" novalidate>
                <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">

                <div class="ak-join-progress" aria-hidden="true">
                    <span>İlerleme</span>
                    <div class="ak-join-progress-track">
                        <div class="ak-join-progress-bar" data-progress-bar></div>
                    </div>
                    <span class="ak-join-progress-count">0 / <?= $soruSayisi ?></span>
                </div>

                <?php foreach ($sorular as $index => $soru):
                    $soruId = (int) $soru['id'];
                    $eskiSecenekId = isset($eskiCevaplar[$soruId]['secenek_id'])
                        ? (int) $eskiCevaplar[$soruId]['secenek_id']
                        : null;
                    $eskiMetin = (string) ($eskiCevaplar[$soruId]['cevap_metni'] ?? '');
                    $tip = (string) ($soru['soru_tipi'] ?? 'coktan_secmeli');
                    $tipLabel = $tip === 'acik_uclu' ? 'Açık uçlu' : 'Çoktan seçmeli';
                    $titleId = 'ak-q-title-' . $soruId;
                    ?>
                <section
                    class="ak-question"
                    data-question-index="<?= $index + 1 ?>"
                    role="group"
                    aria-labelledby="<?= e($titleId) ?>"
                >
                    <div class="ak-question-head">
                        <span class="ak-question-num"><?= $index + 1 ?> / <?= $soruSayisi ?></span>
                        <span class="ak-question-type"><?= e($tipLabel) ?></span>
                    </div>
                    <h2 class="ak-question-title" id="<?= e($titleId) ?>">
                        <?= e((string) ($soru['soru_metni'] ?? '')) ?>
                    </h2>

                    <?php if ($tip === 'coktan_secmeli'): ?>
                        <div class="ak-choice-list" role="radiogroup" aria-labelledby="<?= e($titleId) ?>">
                        <?php foreach (($soru['secenekler'] ?? []) as $secenek):
                            $secenekId = (int) $secenek['id'];
                            $checked = $eskiSecenekId !== null && $eskiSecenekId === $secenekId;
                            $inputId = 'cevap-' . $soruId . '-' . $secenekId;
                            ?>
                        <label class="ak-choice<?= $checked ? ' is-checked' : '' ?>" for="<?= e($inputId) ?>">
                            <input type="radio"
                                   id="<?= e($inputId) ?>"
                                   name="cevap[<?= $soruId ?>]"
                                   value="<?= $secenekId ?>"
                                   <?= $checked ? 'checked' : '' ?>
                                   <?= $dahaOnceKatildi ? 'disabled' : 'required' ?>>
                            <span class="ak-choice-box" aria-hidden="true"></span>
                            <span class="ak-choice-text"><?= e((string) ($secenek['secenek_metni'] ?? '')) ?></span>
                        </label>
                        <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <textarea name="cevap[<?= $soruId ?>]"
                                  rows="4"
                                  placeholder="Yanıtınızı buraya yazınız..."
                                  <?= $dahaOnceKatildi ? 'disabled' : 'required' ?>><?= e($eskiMetin) ?></textarea>
                    <?php endif; ?>
                </section>
                <?php endforeach; ?>

                <div class="ak-join-actions">
                    <a class="ak-btn is-muted" href="<?= e($assetBase) ?>pages/anketler.php">
                        <span class="icon" aria-hidden="true"><?= icon('geri_don') ?></span>
                        Geri Dön
                    </a>
                    <?php if (!$dahaOnceKatildi): ?>
                    <button type="submit" class="ak-btn">
                        <span class="icon" aria-hidden="true"><?= icon('anket_gonder') ?></span>
                        Anketi Tamamla
                    </button>
                    <?php endif; ?>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
<script src="<?= e($assetBase) ?>assets/js/navbar.js" defer></script>
<script>
(function () {
    var form = document.querySelector('.ak-join-form:not(.is-readonly)');
    if (!form) return;
    var bar = document.querySelector('[data-progress-bar]');
    var countEl = document.querySelector('.ak-join-progress-count');
    var fields = Array.prototype.slice.call(form.querySelectorAll('.ak-question'));
    var total = fields.length;
    var readonlyDone = <?= $dahaOnceKatildi ? 'true' : 'false' ?>;

    function answeredCount() {
        var n = 0;
        fields.forEach(function (field) {
            var radio = field.querySelector('input[type="radio"]:checked');
            var area = field.querySelector('textarea');
            if (radio) n += 1;
            else if (area && area.value.trim() !== '') n += 1;
        });
        return n;
    }

    function sync() {
        var done = readonlyDone ? total : answeredCount();
        var pct = total ? Math.round((done / total) * 100) : 0;
        if (bar) bar.style.setProperty('--ak-progress', pct + '%');
        if (countEl) {
            var shown = readonlyDone ? total : Math.min(Math.max(done, 1), total);
            countEl.textContent = shown + ' / ' + total;
        }
    }

    form.addEventListener('change', function () {
        form.querySelectorAll('.ak-choice').forEach(function (lab) {
            lab.classList.toggle('is-checked', !!(lab.querySelector('input:checked')));
        });
        sync();
    });
    form.addEventListener('input', sync);
    sync();
})();
</script>
</body>
</html>
=======
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
>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
