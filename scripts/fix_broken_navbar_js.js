/**
 * Bozuk navbar/profil kod parçalarını sayfa scriptlerinden temizler.
 * Navbar yalnızca navbar.js ile yönetilir.
 */
const fs = require("fs");
const path = require("path");

const jsDir = path.join(__dirname, "..", "JS");
const skip = new Set(["navbar.js"]);

function removeBlock(content, startRe, endRe) {
  let result = content;
  let safety = 0;
  while (safety++ < 100) {
    const m = result.match(startRe);
    if (!m) break;
    const start = m.index;
    const rest = result.slice(start);
    const endM = rest.match(endRe);
    if (!endM) break;
    const end = start + endM.index + endM[0].length;
    result = result.slice(0, start) + result.slice(end);
  }
  return result;
}

function cleanFile(content) {
  let result = content;

  // __profileMenuInit__ blokları
  result = removeBlock(
    result,
    /if\s*\(\s*!window\.__profileMenuInit__\s*\)\s*\{/,
    /\n\}\s*\n/
  );

  // Orphan profil handler kalıntıları (cleanup sonrası)
  result = result.replace(
    /\/\/[^\n]*(?:PROFİL|Profil Dropdown|Profil menü|Profil Açılır)[^\n]*\n[\s\S]*?\n\s*\}\s*\n(?=\s*\/\/[^\n]*(?:MASAÜSTÜ|Navbar|ARAMA|Search|GALERİ|Filtre|YENİ))/gi,
    ""
  );
  result = result.replace(
    /\/\/[^\n]*(?:PROFİL|Profil Dropdown|Profil menü|Profil Açılır)[^\n]*\n\s*\);\s*\n[\s\S]*?\n\s*\}\s*\n/gi,
    ""
  );
  result = result.replace(/^\s*\);\s*$/gm, "");

  // Mobil menü blokları
  result = removeBlock(
    result,
    /\/\/[^\n]*(?:MOBİL YAN MENÜ|Mobil Menü|Mobil menü|MOBİL MENÜ|HAMBURGER)[^\n]*\n/,
    /\n\s*\}\s*\n(?=\s*\/\/|\s*const |\s*\/\/ ---|\s*navDropdowns|\s*\/\/ ----|\s*function |\s*\/\/ ==========)/
  );
  result = removeBlock(
    result,
    /if\s*\(\s*menuToggleBtn\s*&&\s*sideMenu/,
    /\n\s*\}\s*(?:else\s*\{[\s\S]*?\})?\s*\n/
  );

  // Profil değişken tanımları (yalnızca navbar için kullanılan)
  result = result.replace(
    /^\s*const\s+profileBtn\s*=\s*document\.getElementById\("profileBtn"\);\s*\n/gm,
    ""
  );
  result = result.replace(
    /^\s*const\s+profileMenu\s*=\s*document\.getElementById\("profileMenu"\);\s*\n/gm,
    ""
  );
  result = result.replace(
    /^\s*const\s+menuToggleBtn\s*=\s*document\.querySelector\("\.mobile-menu-toggle"\);\s*\n/gm,
    ""
  );
  result = result.replace(
    /^\s*const\s+sideMenu\s*=\s*document\.getElementById\("sideMenu"\);\s*\n/gm,
    ""
  );
  result = result.replace(
    /^\s*const\s+closeMenuBtn\s*=\s*document\.querySelector\("\.close-menu-btn"\);\s*\n/gm,
    ""
  );
  result = result.replace(
    /^\s*const\s+menuBackdrop\s*=\s*document\.getElementById\("menuBackdrop"\);\s*\n/gm,
    ""
  );
  result = result.replace(
    /^\s*const\s+navDropdowns\s*=\s*document\.querySelectorAll\("\.nav-dropdown"\);\s*\n/gm,
    ""
  );

  // Masaüstü nav dropdown handler blokları
  result = removeBlock(
    result,
    /\/\/[^\n]*(?:MASAÜSTÜ NAVBAR|NAVBAR AÇILIR|nav-dropdown|Dropdown Menü)[^\n]*\n/,
    /\n\s*\}\);\s*\n\s*\}\s*\n/
  );
  result = removeBlock(
    result,
    /navDropdowns\.forEach\(\s*\(?\s*(?:navDropdown|dropdown)\s*\)?\s*=>\s*\{/,
    /\n\s*\}\);\s*\n/
  );
  result = removeBlock(
    result,
    /const\s+dropdowns\s*=\s*document\.querySelectorAll\("\.nav-dropdown"\);\s*\n\s*dropdowns\.forEach/,
    /\n\s*\}\);\s*\n/
  );

  // Dışarı tıklama / menü kapatma
  result = removeBlock(
    result,
    /\/\/[^\n]*(?:Sayfada Boş|Sayfaya Tıklayınca|Dışarı tıklamada|menüleri kapat)[^\n]*\n/,
    /\n\s*\}\);\s*\n/
  );
  result = result.replace(
    /function\s+closeAllMenus\s*\(\s*\)\s*\{[\s\S]*?\}\s*\n/g,
    ""
  );

  // ESC ile sadece menü kapatma
  result = result.replace(
    /document\.addEventListener\(\s*["']keydown["']\s*,\s*function\s*\(\s*e\s*\)\s*\{\s*if\s*\(\s*e\.key\s*===\s*["']Escape["']\s*\)\s*\{[\s\S]*?(?:profileMenu|sideMenu|navDropdown)[\s\S]*?\}\s*\}\s*\)\s*;?\s*\n/g,
    ""
  );

  // Profil menü item handler (navbar.js'e taşındı)
  result = removeBlock(
    result,
    /const\s+profileMenuItems\s*=\s*profileMenu\.querySelectorAll/,
    /\n\s*\}\);\s*\n/
  );
  result = removeBlock(
    result,
    /const\s+logoutBtn\s*=\s*profileMenu\.querySelector\("\.logout"\)/,
    /\n\s*\}\);\s*\n/
  );

  // Orphan else from removed if (profileBtn)
  result = result.replace(
    /\n\s*\}\s*else\s*\{\s*\n\s*console\.log\("Profil buton[^\}]*\}\s*\n/g,
    "\n"
  );

  // Boş satır ve orphan parantez
  result = result.replace(/^\s*\}\);\s*$/gm, "");
  result = result.replace(/^\s*\);\s*$/gm, "");
  result = result.replace(/\n{3,}/g, "\n\n");

  return result;
}

function stripNavbarCss(content) {
  const selectors = [
    "navbar",
    "nav-container",
    "nav-links",
    "nav-dropdown",
    "profile-menu",
    "profile-dropdown",
    "profile-btn",
    "side-menu",
    "menu-backdrop",
    "mobile-menu-toggle",
    "logo-img",
    "logo-container",
    "nav-left",
    "nav-center",
    "nav-right",
    "breadcrumb-section",
  ];

  let result = content;
  for (const sel of selectors) {
    const re = new RegExp(
      `(?:^|\\n)\\.${sel.replace(/-/g, "\\-")}[^{]*\\{[^}]*\\}`,
      "gm"
    );
    result = result.replace(re, "\n");
    // multi-rule blocks with nested braces - simple pass
    result = result.replace(
      new RegExp(`\\.${sel.replace(/-/g, "\\-")}[\\s\\S]*?\\n\\}`, "m"),
      ""
    );
  }
  result = result.replace(/\n{3,}/g, "\n\n");
  return result;
}

for (const file of fs.readdirSync(jsDir).filter((f) => f.endsWith(".js"))) {
  if (skip.has(file)) continue;
  const filePath = path.join(jsDir, file);
  const original = fs.readFileSync(filePath, "utf8");
  const cleaned = cleanFile(original);
  if (cleaned !== original) {
    fs.writeFileSync(filePath, cleaned);
    console.log("Fixed JS:", file);
  }
}

const cssDir = path.join(__dirname, "..", "CSS");
for (const file of fs.readdirSync(cssDir).filter((f) => f.endsWith(".style.css"))) {
  const filePath = path.join(cssDir, file);
  const original = fs.readFileSync(filePath, "utf8");
  if (!/\.profile-btn\s*\{|\.profile-menu\s*\{|\.navbar\s*\{/.test(original)) continue;
  const cleaned = stripNavbarCss(original);
  if (cleaned !== original) {
    fs.writeFileSync(filePath, cleaned);
    console.log("Fixed CSS:", file);
  }
}
