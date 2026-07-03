/**
 * Tüm PHP sayfalarında site-styles.php ve navbar.js kullanımını standartlaştırır.
 */
const fs = require("fs");
const path = require("path");

const pagesDir = path.join(__dirname, "..", "pages");
const skip = new Set(["baglan.php", "login.php", "sifre.php"]);

const pageCssMap = {
  "ana_sayfa.php": "ana_sayfa.style.css",
  "videolar.php": "videolar.style.css",
  "protokol.php": "protokol.style.css",
  "dokumanlar.php": "dokumanlar.style.css",
  "mevzuat.php": "mevzuat.style.css",
  "egitim.php": "egitim.style.css",
  "duyuru.php": "duyuru.style.css",
  "etkinlikler.php": "etkinlik.style.css",
  "etkinlikd.php": "etkinlik_detay.style.css",
  "sizden_gelenler.php": "sizden_gelenler.style.css",
  "sizden.php": "sizden_gelen_detay.style.css",
  "haber_detay.php": "haber_detay.style.css",
  "anketler.php": "anketler.style.css",
  "yardimci_linkler.php": "yardimci_link.style.css",
  "vefat_bilgisi.php": "vefat_bilgisi.style.css",
  "dogum.php": "dogum.style.css",
};

for (const file of fs.readdirSync(pagesDir).filter((f) => f.endsWith(".php"))) {
  if (skip.has(file)) continue;
  const filePath = path.join(pagesDir, file);
  let content = fs.readFileSync(filePath, "utf8");
  if (!content.includes("header-nav.php")) continue;

  const pageCss = pageCssMap[file] || "";

  content = content.replace(
    /\s*<link rel="stylesheet" href="\.\.\/CSS\/responsive\.css" \/>[\s\S]*?<link rel="stylesheet" href="\.\.\/CSS\/brand\.css" \/>/m,
    pageCss
      ? `\n<?php $pageCss = "${pageCss}"; include "includes/site-styles.php"; ?>`
      : `\n<?php include "includes/site-styles.php"; ?>`
  );

  if (!content.includes("navbar.js")) {
    content = content.replace(
      /<\/body>/i,
      '    <script src="../JS/navbar.js"></script>\n  </body>'
    );
  }

  fs.writeFileSync(filePath, content);
  console.log("Updated styles:", file);
}
