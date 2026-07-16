<?php
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

    function syncCheckedClass() {
        form.querySelectorAll('.ak-choice').forEach(function (lab) {
            lab.classList.toggle('is-checked', !!(lab.querySelector('input:checked')));
        });
    }

    form.querySelectorAll('.ak-choice').forEach(function (lab) {
        var radio = lab.querySelector('input[type="radio"]');
        if (!radio || radio.disabled) return;

        lab.addEventListener('mousedown', function () {
            radio.dataset.wasChecked = radio.checked ? '1' : '0';
        });

        lab.addEventListener('click', function (e) {
            if (radio.dataset.wasChecked !== '1') return;
            e.preventDefault();
            radio.checked = false;
            radio.dataset.wasChecked = '0';
            syncCheckedClass();
            sync();
        });
    });

    form.addEventListener('change', function () {
        syncCheckedClass();
        sync();
    });
    form.addEventListener('input', sync);
    sync();
})();
</script>
</body>
</html>
