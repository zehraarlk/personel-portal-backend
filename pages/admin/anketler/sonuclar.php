<?php
/**
 * Dosya sorumluluğu: Anket sonuçlarını raporlar.
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
$pageTitle = "Anket Raporu: " . $anket["baslik"];

// Toplam tekil katılan personel sayısı
$toplamKatilim = (int)(dbFetchOne($db, "SELECT COUNT(DISTINCT personel_id) as c FROM anket_cevaplari WHERE anket_id = ?", [$anket_id])["c"] ?? 0);

// Soruları çekelim
$sorular = dbFetchAll($db, "SELECT * FROM anket_sorulari WHERE anket_id = ? ORDER BY sira ASC, id ASC", [$anket_id]);

include __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3 bg-white p-3 rounded shadow-sm">
    <div>
        <h5 class="mb-1 text-dark fw-bold"><?= htmlspecialchars($anket["baslik"], ENT_QUOTES, "UTF-8") ?></h5>
        <p class="text-muted small mb-0">Bu ankete toplam <strong><?= $toplamKatilim ?></strong> personel katılım sağladı.</p>
    </div>
    <a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm d-flex align-items-center gap-2">
        <i class="fas fa-arrow-left"></i> Geri Dön
    </a>
</div>

<div class="row">
    <?php foreach ($sorular as $index => $soru): ?>
        <div class="col-md-6 mb-4">
            <div class="admin-card h-100 shadow-sm border-0">
                <div class="admin-card-header bg-light py-3 border-bottom">
                    <h6 class="mb-0 fw-bold text-secondary">
                        <span class="badge bg-primary me-2">Soru <?= $index + 1 ?></span> 
                        <?= htmlspecialchars($soru["soru_metni"], ENT_QUOTES, "UTF-8") ?>
                    </h6>
                </div>
                <div class="admin-card-body p-4">
                    <?php if ($soru["soru_tipi"] === "coktan_secmeli"): 
                        // Şıkların oy dağılımını hesaplayalım
                        $istatistik = dbFetchAll($db, "
                            SELECT s.id, s.secenek_metni, COUNT(c.id) as oy_sayisi 
                            FROM anket_secenekleri s 
                            LEFT JOIN anket_cevaplari c ON c.secenek_id = s.id 
                            WHERE s.soru_id = ? 
                            GROUP BY s.id
                        ", [$soru["id"]]);
                        
                        $labels = [];
                        $data = [];
                        $toplamSoruOyu = 0;
                        
                        foreach ($istatistik as $ist) {
                            $labels[] = $ist["secenek_metni"];
                            $data[] = (int)$ist["oy_sayisi"];
                            $toplamSoruOyu += (int)$ist["oy_sayisi"];
                        }
                        
                        // Grafik renk paleti
                        $renkler = ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1', '#fd7e14'];
                    ?>
                        <?php if ($toplamSoruOyu === 0): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-chart-bar fa-2x text-muted mb-2 opacity-50"></i>
                                <p class="text-muted small mb-0">Bu soruya henüz hiç oy verilmemiş.</p>
                            </div>
                        <?php else: ?>
                            <div class="d-flex justify-content-center mb-4" style="max-height: 200px; position: relative;">
                                <canvas id="chart_<?= $soru["id"] ?>"></canvas>
                            </div>

                            <div class="mt-3">
                                <span class="text-muted small fw-bold d-block mb-2">OY DAĞILIM DETAYLARI</span>
                                <?php foreach ($istatistik as $kAnahtar => $ist): 
                                    $oy = (int)$ist["oy_sayisi"];
                                    $yuzde = $toplamSoruOyu > 0 ? round(($oy / $toplamSoruOyu) * 100, 1) : 0;
                                    $aktifRenk = $renkler[$kAnahtar % count($renkler)];
                                ?>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1 small">
                                            <span class="text-dark fw-medium">
                                                <i class="fas fa-circle me-1" style="color: <?= $aktifRenk ?>; font-size: 10px;"></i>
                                                <?= htmlspecialchars($ist["secenek_metni"], ENT_QUOTES, "UTF-8") ?>
                                            </span>
                                            <span class="text-muted fw-bold"><?= $oy ?> Oy ( %<?= $yuzde ?> )</span>
                                        </div>
                                        <div class="progress" style="height: 8px; background-color: #e9ecef;">
                                            <div class="progress-bar rounded-pill" role="progressbar" 
                                                 style="width: <?= $yuzde ?>%; background-color: <?= $aktifRenk ?>;" 
                                                 aria-valuenow="<?= $yuzde ?>" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                new Chart(document.getElementById('chart_<?= $soru["id"] ?>'), {
                                    type: 'pie',
                                    data: {
                                        labels: <?= json_encode($labels) ?>,
                                        datasets: [{
                                            data: <?= json_encode($data) ?>,
                                            backgroundColor: <?= json_encode(array_slice($renkler, 0, count($data))) ?>
                                        }]
                                    },
                                    options: { 
                                        responsive: true, 
                                        maintainAspectRatio: false,
                                        plugins: { legend: { display: false } } // İçerik karmaşasını önlemek için legend'ı gizleyip aşağıda progress bar yaptık
                                    }
                                });
                            });
                            </script>
                        <?php endif; ?>

                    <?php else: 
                        // Açık uçlu soru yanıt dökümleri
                        $cevaplar = dbFetchAll($db, "
                            SELECT c.cevap_metni, p.ad, p.soyad, p.sicil_no 
                            FROM anket_cevaplari c 
                            JOIN personeller p ON c.personel_id = p.id 
                            WHERE c.soru_id = ? AND c.cevap_metni IS NOT NULL AND c.cevap_metni != ''
                        ", [$soru["id"]]);
                    ?>
                        <div style="max-height: 320px; overflow-y: auto;" class="p-2 border rounded bg-light">
                            <?php if (empty($cevaplar)): ?>
                                <p class="text-muted small text-center my-4">Henüz yazılı cevap girilmemiş.</p>
                            <?php else: ?>
                                <?php foreach ($cevaplar as $cvp): ?>
                                    <div class="bg-white p-3 rounded mb-2 shadow-sm small border-start border-secondary border-3">
                                        <div class="d-flex justify-content-between text-muted mb-1" style="font-size: 11px;">
                                            <strong><?= htmlspecialchars($cvp["ad"]." ".$cvp["soyad"], ENT_QUOTES, "UTF-8") ?></strong>
                                            <span>Sicil No: <?= htmlspecialchars($cvp["sicil_no"], ENT_QUOTES, "UTF-8") ?></span>
                                        </div>
                                        <p class="text-dark mb-0 style-text" style="line-height: 1.4;"><?= nl2br(htmlspecialchars($cvp["cevap_metni"], ENT_QUOTES, "UTF-8")) ?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>