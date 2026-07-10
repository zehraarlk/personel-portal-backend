<?php
require_once __DIR__ . "/../includes/auth.php";

if (!empty($_SESSION["yonetici_id"])) {
  $oturumId = (int) ($_SESSION["yonetici_oturum_id"] ?? 0);
  if ($oturumId > 0) {
    try {
      $db
        ->prepare(
          "UPDATE yonetici_oturum_kayitlari SET cikis_zamani = NOW() WHERE id = ? AND cikis_zamani IS NULL",
        )
        ->execute([$oturumId]);
    } catch (Throwable $e) {
      // Sessizce geç
    }
  }
}

unset(
  $_SESSION["yonetici_id"],
  $_SESSION["yonetici_kullanici"],
  $_SESSION["yonetici_ad"],
  $_SESSION["yonetici_soyad"],
  $_SESSION["yonetici_yetki"],
  $_SESSION["yonetici_oturum_id"],
  $_SESSION["admin_csrf"],
);

header("Location: ../yonetim_giris.php");
exit();
