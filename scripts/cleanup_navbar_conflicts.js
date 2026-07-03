/**
 * Sayfa JS dosyalarındaki çift profil menü handler'larını devre dışı bırakır.
 * Navbar menüsü yalnızca navbar.js tarafından yönetilir.
 */
const fs = require("fs");
const path = require("path");

const jsDir = path.join(__dirname, "..", "JS");

function stripBetween(content, startPattern, endPattern) {
  let result = content;
  let safety = 0;
  while (safety++ < 50) {
    const start = result.search(startPattern);
    if (start === -1) break;
    const end = result.slice(start).search(endPattern);
    if (end === -1) break;
    const removeEnd = start + end + endPattern.source.length;
    result = result.slice(0, start) + result.slice(removeEnd);
  }
  return result;
}

function stripProfileHandlers(content) {
  let result = content;

  // profileBtn click handler blokları
  result = result.replace(
    /if\s*\(\s*profileBtn\s*&&\s*profileMenu\s*\)\s*\{[\s\S]*?\n\s*\}\s*/g,
    ""
  );

  // document click ile profil kapatma (yaygın pattern)
  result = result.replace(
    /document\.addEventListener\(\s*["']click["']\s*,\s*function\s*\([^)]*\)\s*\{[\s\S]*?profileMenu[\s\S]*?\}\s*\)\s*;?/g,
    ""
  );
  result = result.replace(
    /document\.addEventListener\(\s*["']click["']\s*,\s*\([^)]*\)\s*=>\s*\{[\s\S]*?profileMenu[\s\S]*?\}\s*\)\s*;?/g,
    ""
  );

  // Tek satır profil kapatma
  result = result.replace(
    /^\s*if\s*\(\s*profileMenu\s*&&\s*!profileBtn\.contains[\s\S]*?\}\s*;?\s*$/gm,
    ""
  );

  result = result.replace(/\n{3,}/g, "\n\n");
  return result;
}

function stripNavbarCss(content) {
  const markers = [
    /^\.navbar\s*\{/m,
    /^\/\* === TEMEL NAVBAR/m,
    /^\.nav-container\s*\{/m,
    /^\.profile-menu\s*\{/m,
    /^\.nav-links\s*\{/m,
    /^\.side-menu\s*\{/m,
    /^\.menu-backdrop\s*\{/m,
    /^\.logo-img\s*\{/m,
    /^\.mobile-menu-toggle\s*\{/m,
    /^\.nav-dropdown-menu\s*\{/m,
    /^\.profile-dropdown\s*\{/m,
    /^\.profile-btn\s*\{/m,
  ];

  let result = content;
  for (const marker of markers) {
    result = result.replace(
      new RegExp(
        marker.source.replace(/^\^/, "").replace(/\$$/, "") +
          "[\\s\\S]*?\\n\\}",
        "m"
      ),
      ""
    );
  }

  // @media blokları içinde sadece navbar kuralları - basit temizlik
  result = result.replace(
    /@media\s*\(max-width:\s*992px\)\s*\{\s*\.navbar[\s\S]*?\}\s*\}/g,
    ""
  );

  result = result.replace(/\n{3,}/g, "\n\n");
  return result;
}

for (const file of fs.readdirSync(jsDir).filter((f) => f.endsWith(".js"))) {
  if (file === "navbar.js") continue;
  const filePath = path.join(jsDir, file);
  const original = fs.readFileSync(filePath, "utf8");
  const cleaned = stripProfileHandlers(original);
  if (cleaned !== original) {
    fs.writeFileSync(filePath, cleaned);
    console.log("JS cleaned:", file);
  }
}

const cssDir = path.join(__dirname, "..", "CSS");
for (const file of fs.readdirSync(cssDir).filter((f) => f.endsWith(".style.css"))) {
  const filePath = path.join(cssDir, file);
  const original = fs.readFileSync(filePath, "utf8");
  if (!/\.navbar\s*\{|\.profile-menu\s*\{|\.nav-links\s*\{/.test(original)) continue;
  const cleaned = stripNavbarCss(original);
  if (cleaned !== original) {
    fs.writeFileSync(filePath, cleaned);
    console.log("CSS cleaned:", file);
  }
}
