const fs = require("fs");
const path = require("path");

const pagesDir = path.join(__dirname, "..", "pages");
const skip = new Set(["baglan.php", "login.php", "sifre.php"]);

const titleMap = {
  "ana_sayfa.php": "",
  "videolar.php": "Videolar",
  "protokol.php": "Protokoller",
  "dokumanlar.php": "Dokümanlar",
  "mevzuat.php": "Mevzuatlar",
  "egitim.php": "Eğitim",
  "duyuru.php": "Duyurular",
  "etkinlikler.php": "Etkinlikler",
  "etkinlikd.php": "Etkinlik Detayı",
  "sizden_gelenler.php": "Sizden Gelenler",
  "sizden.php": "Sizden Gelenler",
  "haber_detay.php": "Haber Detayı",
  "anketler.php": "Anketler",
  "yardimci_linkler.php": "Yardımcı Linkler",
  "vefat_bilgisi.php": "Vefat Bilgisi",
  "dogum.php": "Doğum Günü",
};

function extractTitle(content, file) {
  if (Object.prototype.hasOwnProperty.call(titleMap, file)) {
    return titleMap[file];
  }
  const idMatch = content.match(/id="breadcrumbTitle"[^>]*>\s*([^<]+)/);
  if (idMatch) return idMatch[1].trim();
  const activeMatch = content.match(
    /class="breadcrumb-item active"[^>]*>(?:\s*<[^>]+>)*\s*([^<\n]+)/
  );
  if (activeMatch) return activeMatch[1].trim();
  return "";
}

for (const file of fs.readdirSync(pagesDir).filter((f) => f.endsWith(".php"))) {
  if (skip.has(file)) continue;

  const filePath = path.join(pagesDir, file);
  let content = fs.readFileSync(filePath, "utf8");
  if (!content.includes('<nav class="navbar">')) continue;

  const pageTitle = extractTitle(content, file);

  content = content.replace(/<nav class="navbar">[\s\S]*?<\/nav>\s*/m, "");
  content = content.replace(
    /<div class="menu-backdrop"[\s\S]*?<\/ul>\s*<\/div>\s*/m,
    ""
  );
  content = content.replace(
    /<div id="menuBackdrop"[\s\S]*?<\/ul>\s*<\/div>\s*/m,
    ""
  );
  content = content.replace(
    /\s*<div class="breadcrumb-section">[\s\S]*?<\/div>\s*<\/div>\s*/m,
    ""
  );

  let insert = '    <?php include "includes/header-nav.php"; ?>\n';
  if (pageTitle) {
    insert += `    <?php $pageTitle = ${JSON.stringify(pageTitle)}; include "includes/breadcrumb.php"; ?>\n`;
  }

  content = content.replace(/<body>\s*/i, `<body>\n${insert}`);

  if (!content.includes("navbar.js")) {
    content = content.replace(
      /<\/body>/i,
      '    <script src="../JS/navbar.js"></script>\n  </body>'
    );
  }

  fs.writeFileSync(filePath, content);
  console.log("Updated:", file, pageTitle || "(no breadcrumb)");
}
