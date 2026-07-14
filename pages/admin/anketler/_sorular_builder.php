<?php
/**
 * Anket soru builder parçası.
 * Beklenen: $sorular (array), $sorularKilitli (bool)
 */
$sorular = is_array($sorular ?? null) ? $sorular : [];
$sorularKilitli = !empty($sorularKilitli);
$maxSoru = 10;
$initialCount = max(1, min($maxSoru, count($sorular) ?: 1));
?>
<div
  id="anketSorularBuilder"
  class="admin-anket-sorular border rounded-3 p-3 mb-4"
  data-locked="<?= $sorularKilitli ? "1" : "0" ?>"
  data-max-soru="<?= (int) $maxSoru ?>"
>
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <h4 class="h6 mb-0">Sorular</h4>
    <div class="d-flex align-items-center gap-2">
      <label class="form-label mb-0 small" for="soruSayisi">Soru sayısı</label>
      <select
        id="soruSayisi"
        class="form-select form-select-sm admin-soru-sayisi"
        <?= $sorularKilitli ? "disabled" : "" ?>
      >
        <?php for ($i = 1; $i <= $maxSoru; $i++): ?>
          <option value="<?= $i ?>" <?= $i === $initialCount ? "selected" : "" ?>><?= $i ?></option>
        <?php endfor; ?>
      </select>
    </div>
  </div>

  <?php if ($sorularKilitli): ?>
    <div class="admin-alert admin-alert-warning mb-3">
      Bu ankete cevap verildiği için sorular kilitli. Yalnızca anket bilgileri güncellenebilir.
    </div>
  <?php endif; ?>

  <div id="anketSorularList" class="d-flex flex-column gap-3">
    <?php foreach ($sorular as $qi => $soru):
      $tip = (string) ($soru["soru_tipi"] ?? "coktan_secmeli");
      $secenekler = $soru["secenekler"] ?? [];
      if ($tip === "coktan_secmeli" && count($secenekler) < 2) {
        $secenekler = [["secenek_metni" => ""], ["secenek_metni" => ""]];
      }
      ?>
    <div class="card shadow-sm" data-soru-card>
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <strong data-soru-title>Soru <?= (int) $qi + 1 ?></strong>
        </div>
        <div class="mb-2">
          <label class="form-label">Soru metni *</label>
          <textarea
            name="sorular[<?= (int) $qi ?>][metin]"
            class="form-control"
            rows="2"
            <?= $sorularKilitli ? "readonly" : "required" ?>
          ><?= htmlspecialchars(
            (string) ($soru["soru_metni"] ?? ""),
            ENT_QUOTES,
            "UTF-8",
          ) ?></textarea>
        </div>
        <div class="mb-2">
          <label class="form-label">Soru tipi</label>
          <select
            name="sorular[<?= (int) $qi ?>][tip]"
            class="form-select"
            data-soru-tip
            <?= $sorularKilitli ? "disabled" : "" ?>
          >
            <option value="coktan_secmeli" <?= $tip === "coktan_secmeli"
              ? "selected"
              : "" ?>>Çoktan seçmeli</option>
            <option value="acik_uclu" <?= $tip === "acik_uclu"
              ? "selected"
              : "" ?>>Açık uçlu</option>
          </select>
          <?php if ($sorularKilitli): ?>
            <input type="hidden" name="sorular[<?= (int) $qi ?>][tip]" value="<?= htmlspecialchars(
  $tip,
  ENT_QUOTES,
  "UTF-8",
) ?>" />
          <?php endif; ?>
        </div>
        <div data-secenekler <?= $tip === "acik_uclu" ? "hidden" : "" ?>>
          <label class="form-label">Seçenekler</label>
          <div class="d-flex flex-column gap-2" data-secenek-list>
            <?php foreach ($secenekler as $secenek): ?>
            <div class="input-group" data-secenek-row>
              <input
                type="text"
                class="form-control"
                name="sorular[<?= (int) $qi ?>][secenekler][]"
                value="<?= htmlspecialchars(
                  (string) ($secenek["secenek_metni"] ?? $secenek ?? ""),
                  ENT_QUOTES,
                  "UTF-8",
                ) ?>"
                placeholder="Seçenek"
                <?= $sorularKilitli ? "readonly" : "" ?>
              />
              <button
                type="button"
                class="btn btn-outline-danger"
                data-remove-secenek
                <?= $sorularKilitli ? "disabled" : "" ?>
              >
                <i class="fas fa-times"></i>
              </button>
            </div>
            <?php endforeach; ?>
          </div>
          <button
            type="button"
            class="btn btn-sm btn-outline-primary mt-2"
            data-add-secenek
            <?= $sorularKilitli || $tip === "acik_uclu" ? "hidden" : "" ?>
          >
            <i class="fas fa-plus"></i> Seçenek ekle
          </button>
        </div>
      </div>
    </div>
    <?php
    endforeach; ?>
  </div>
</div>

<template id="anketSoruTemplate">
  <div class="card shadow-sm" data-soru-card>
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <strong data-soru-title>Soru</strong>
      </div>
      <div class="mb-2">
        <label class="form-label">Soru metni *</label>
        <textarea name="sorular[__I__][metin]" class="form-control" rows="2" required></textarea>
      </div>
      <div class="mb-2">
        <label class="form-label">Soru tipi</label>
        <select name="sorular[__I__][tip]" class="form-select" data-soru-tip>
          <option value="coktan_secmeli" selected>Çoktan seçmeli</option>
          <option value="acik_uclu">Açık uçlu</option>
        </select>
      </div>
      <div data-secenekler>
        <label class="form-label">Seçenekler</label>
        <div class="d-flex flex-column gap-2" data-secenek-list>
          <div class="input-group" data-secenek-row>
            <input type="text" class="form-control" name="sorular[__I__][secenekler][]" placeholder="Seçenek" />
            <button type="button" class="btn btn-outline-danger" data-remove-secenek>
              <i class="fas fa-times"></i>
            </button>
          </div>
          <div class="input-group" data-secenek-row>
            <input type="text" class="form-control" name="sorular[__I__][secenekler][]" placeholder="Seçenek" />
            <button type="button" class="btn btn-outline-danger" data-remove-secenek>
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <button type="button" class="btn btn-sm btn-outline-primary mt-2" data-add-secenek>
          <i class="fas fa-plus"></i> Seçenek ekle
        </button>
      </div>
    </div>
  </div>
</template>

<template id="anketSecenekTemplate">
  <div class="input-group" data-secenek-row>
    <input type="text" class="form-control" name="sorular[__I__][secenekler][]" placeholder="Seçenek" />
    <button type="button" class="btn btn-outline-danger" data-remove-secenek>
      <i class="fas fa-times"></i>
    </button>
  </div>
</template>
