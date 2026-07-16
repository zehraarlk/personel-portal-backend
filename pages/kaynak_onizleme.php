<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/icons.php';

$id = (int) ($_GET['id'] ?? 0);
$row = fetchKaynakById(getPDO(), $id);

if ($row === null) {
    header('Location: ' . $assetBase . 'pages/dokumanlar.php');
    exit;
}

$dbPath = trim((string) ($row['onizleme'] ?? ''));
if ($dbPath === '') {
    $dbPath = trim((string) ($row['dosya_yolu'] ?? ''));
}

$baslik = trim((string) ($row['baslik'] ?? 'Doküman Önizleme'));
$isRemote = (bool) preg_match('#^https?://#i', $dbPath);
$info = $isRemote ? null : kaynakLocalFileInfo($dbPath);

// Uzantıyı her zaman dosya yolundan al (disk çözümü başarısız olsa bile).
$pathForExt = $isRemote
    ? (string) (parse_url($dbPath, PHP_URL_PATH) ?: $dbPath)
    : $dbPath;
$ext = strtolower((string) pathinfo($pathForExt, PATHINFO_EXTENSION));
if ($info !== null && ($info['ext'] ?? '') !== '') {
    $ext = (string) $info['ext'];
}

$fileStreamUrl = 'kaynak_dosya.php?id=' . $id . '&inline=1';
$downloadUrl = 'kaynak_dosya.php?id=' . $id;
$remoteUrl = $isRemote ? $dbPath : '';

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = (string) ($_SERVER['HTTP_HOST'] ?? 'localhost');
$scriptDir = str_replace('\\', '/', dirname((string) ($_SERVER['SCRIPT_NAME'] ?? '')));
$absoluteStream = $scheme . '://' . $host . rtrim($scriptDir, '/') . '/kaynak_dosya.php?id=' . $id . '&inline=1';

$mode = 'unsupported';
if ($ext === 'pdf') {
    $mode = 'pdf';
} elseif (in_array($ext, ['png', 'jpg', 'jpeg', 'gif', 'webp'], true)) {
    $mode = 'image';
} elseif ($ext === 'docx') {
    $mode = 'docx';
} elseif (in_array($ext, ['xlsx', 'xls', 'csv'], true)) {
    $mode = 'sheet';
} elseif (in_array($ext, ['doc', 'ppt', 'pptx'], true) || $isRemote) {
    // Yerelde Google/Office viewer localhost'a erişemez; yine de gömülü dene,
    // başarısızsa not + indirme ile devam edilir.
    $mode = 'office-remote';
}

$pageTitle = 'Doküman Önizleme';
$documentTitle = $baslik;
$showBreadcrumb = true;
$pageCss = 'kaynak-onizleme.css';

require __DIR__ . '/../includes/site-head.php';
require __DIR__ . '/../includes/header-nav.php';
require __DIR__ . '/../includes/breadcrumb.php';
?>

<main class="content-area kaynak-onizleme-page">
    <div class="site-container">
        <header class="kr-preview-header">
            <div>
                <h1><?= e($baslik) ?></h1>
                <p><?= e(strtoupper($ext !== '' ? $ext : 'DOSYA')) ?> önizleme</p>
            </div>
            <div class="kr-preview-actions">
                <a class="kr-card-btn is-secondary" href="<?= e($isRemote ? $remoteUrl : $downloadUrl) ?>" <?= $isRemote ? 'target="_blank" rel="noopener noreferrer"' : 'download' ?>>
                    İndir
                </a>
                <a class="kr-card-btn" href="<?= e($assetBase) ?>pages/dokumanlar.php">Geri Dön</a>
            </div>
        </header>

        <section class="kr-preview-frame" aria-label="Önizleme alanı">
            <?php if ($mode === 'pdf'): ?>
                <iframe
                    class="kr-preview-embed"
                    title="<?= e($baslik) ?>"
                    src="<?= e($isRemote ? $remoteUrl : $fileStreamUrl) ?>"
                ></iframe>
            <?php elseif ($mode === 'image'): ?>
                <div class="kr-preview-image-wrap">
                    <img src="<?= e($isRemote ? $remoteUrl : $fileStreamUrl) ?>" alt="<?= e($baslik) ?>">
                </div>
            <?php elseif ($mode === 'docx'): ?>
                <div id="docxPreview" class="kr-preview-docx" data-src="<?= e($fileStreamUrl) ?>">
                    <p class="kr-preview-loading">Önizleme hazırlanıyor…</p>
                </div>
            <?php elseif ($mode === 'sheet'): ?>
                <div id="sheetPreview" class="kr-preview-sheet" data-src="<?= e($fileStreamUrl) ?>">
                    <p class="kr-preview-loading">Önizleme hazırlanıyor…</p>
                </div>
            <?php elseif ($mode === 'office-remote'): ?>
                <?php
                $viewerSrc = $isRemote
                    ? 'https://view.officeapps.live.com/op/embed.aspx?src=' . rawurlencode($remoteUrl)
                    : 'https://docs.google.com/gview?embedded=1&url=' . rawurlencode($absoluteStream);
                $isLegacyDoc = $ext === 'doc';
                ?>
                <?php if (!$isRemote && $isLegacyDoc): ?>
                <div class="kr-preview-empty">
                    <p>
                        Bu dosya eski <strong>.doc</strong> (Word 97–2003) formatında.
                        Tarayıcıda güvenilir önizleme için dosyayı <strong>.docx</strong> olarak kaydedip yeniden yükleyin.
                    </p>
                    <p class="kr-preview-note-inline">Şimdilik dosyayı indirerek bilgisayarınızda açabilirsiniz.</p>
                    <a class="kr-card-btn" href="<?= e($downloadUrl) ?>">Dosyayı İndir</a>
                </div>
                <?php else: ?>
                <iframe
                    class="kr-preview-embed"
                    title="<?= e($baslik) ?>"
                    src="<?= e($viewerSrc) ?>"
                ></iframe>
                <p class="kr-preview-note">
                    Önizleme yüklenmezse dosyayı indirerek açabilirsiniz.
                </p>
                <?php endif; ?>
            <?php else: ?>
                <div class="kr-preview-empty">
                    <p>
                        <?= $ext !== ''
                            ? '“.' . e($ext) . '” dosya türü tarayıcıda önizlenemiyor.'
                            : 'Bu dosya türü tarayıcıda önizlenemiyor.' ?>
                    </p>
                    <a class="kr-card-btn" href="<?= e($isRemote ? $remoteUrl : $downloadUrl) ?>" <?= $isRemote ? 'target="_blank" rel="noopener noreferrer"' : '' ?>>Dosyayı İndir</a>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php if ($mode === 'docx'): ?>
<script src="https://cdn.jsdelivr.net/npm/jszip@3.10.1/dist/jszip.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/docx-preview@0.3.5/dist/docx-preview.min.js"></script>
<script>
(function () {
    var el = document.getElementById('docxPreview');
    if (!el || !window.docx) return;
    fetch(el.getAttribute('data-src'), { credentials: 'same-origin' })
        .then(function (res) {
            if (!res.ok) throw new Error('Dosya okunamadı');
            return res.arrayBuffer();
        })
        .then(function (buffer) {
            el.innerHTML = '';
            return window.docx.renderAsync(buffer, el, null, {
                className: 'kr-docx',
                inWrapper: true,
                ignoreWidth: true,
                breakPages: true,
                useBase64URL: true
            });
        })
        .catch(function () {
            el.innerHTML = '<p class="kr-preview-empty">Önizleme yüklenemedi. Lütfen dosyayı indirin.</p>';
        });
})();
</script>
<?php endif; ?>

<?php if ($mode === 'sheet'): ?>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script>
(function () {
    var el = document.getElementById('sheetPreview');
    if (!el || !window.XLSX) return;
    fetch(el.getAttribute('data-src'), { credentials: 'same-origin' })
        .then(function (res) {
            if (!res.ok) throw new Error('Dosya okunamadı');
            return res.arrayBuffer();
        })
        .then(function (buffer) {
            var workbook = window.XLSX.read(buffer, { type: 'array' });
            var sheetName = workbook.SheetNames[0];
            var html = window.XLSX.utils.sheet_to_html(workbook.Sheets[sheetName]);
            el.innerHTML = html;
        })
        .catch(function () {
            el.innerHTML = '<p class="kr-preview-empty">Önizleme yüklenemedi. Lütfen dosyayı indirin.</p>';
        });
})();
</script>
<?php endif; ?>

<?php require __DIR__ . '/../includes/footer.php'; ?>
<script src="<?= e($assetBase) ?>assets/js/navbar.js" defer></script>
</body>
</html>
