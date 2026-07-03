/**
 * Sayfa scriptlerinde kalan tüm navbar/profil handler bloklarını kaldırır.
 */
const fs = require("fs");
const path = require("path");

const jsDir = path.join(__dirname, "..", "JS");

function removeBraceBlock(content, openBraceIndex) {
  let depth = 0;
  let started = false;
  for (let i = openBraceIndex; i < content.length; i++) {
    const ch = content[i];
    if (ch === "{") {
      depth++;
      started = true;
    } else if (ch === "}") {
      depth--;
      if (started && depth === 0) {
        return content.slice(0, openBraceIndex) + content.slice(i + 1);
      }
    }
  }
  return content;
}

function removePatternBlock(content, pattern) {
  let result = content;
  let safety = 0;
  while (safety++ < 50) {
    const m = result.match(pattern);
    if (!m) break;
    const start = m.index;
    const brace = result.indexOf("{", start);
    if (brace === -1) break;
    result = removeBraceBlock(result, brace);
    // yorum satırını da sil
    const lineStart = result.lastIndexOf("\n", start) + 1;
    const commentChunk = result.slice(lineStart, start);
    if (/^\s*\/\//.test(commentChunk)) {
      result = result.slice(0, lineStart) + result.slice(brace);
      result = removeBraceBlock(result, result.indexOf("{", lineStart));
    }
  }
  return result;
}

function clean(content) {
  let result = content;

  result = result.replace(
    /if\s*\(\s*!window\.__profileMenuInit__\s*\)\s*\{[\s\S]*?\n\}\s*\n?/g,
    ""
  );

  const patterns = [
    /if\s*\(\s*profileBtn\s*&&\s*profileMenu\s*\)/,
    /if\s*\(\s*menuToggleBtn\s*&&\s*sideMenu/,
    /if\s*\(\s*navDropdown\s*&&\s*dropdownToggle\s*\)/,
  ];

  for (const p of patterns) {
    result = removePatternBlock(result, p);
  }

  // Profile dropdown functionality yorumlu bloklar
  result = result.replace(
    /\/\/\s*Profile dropdown functionality\s*\n[\s\S]*?(?=\n\s*\/\/\s*---|\n\s*\/\/\s*====|\n\s*function\s+[a-zA-Z]|\n\s*document\.addEventListener\("DOMContentLoaded")/g,
    ""
  );

  // PROFİL / MOBİL / MASAÜSTÜ navbar bölüm yorumları + takip eden kod
  result = result.replace(
    /\/\/\s*---\s*(?:PROFİL|MOBİL|MASAÜSTÜ|Sayfada Boş)[^\n]*\n[\s\S]*?(?=\n\s*\/\/\s*---\s*(?!PROFİL|MOBİL|MASAÜSTÜ|Sayfada)|\n\s*\/\/\s*====|\n\s*function\s|\n\s*\/\/\s*Initialize|\n\s*\/\/\s*DOM)/g,
    ""
  );

  // document click sadece profileMenu/navDropdown kapatma
  result = result.replace(
    /document\.addEventListener\(\s*["']click["']\s*,\s*function\s*\(\s*e\s*\)\s*\{[\s\S]*?(?:profileMenu|navDropdown)[\s\S]*?\}\s*\)\s*;?\s*\n/g,
    ""
  );

  result = result.replace(
    /document\.addEventListener\(\s*["']keydown["']\s*,\s*function\s*\(\s*e\s*\)\s*\{[\s\S]*?(?:profileMenu|sideMenu|navDropdown)[\s\S]*?\}\s*\)\s*;?\s*\n/g,
    ""
  );

  // Kullanılmayan üst seviye navbar değişkenleri
  result = result.replace(
    /^const\s+(?:profileBtn|profileMenu|menuToggleBtn|sideMenu|closeMenuBtn|menuBackdrop|navDropdown|dropdownToggle)\s*=[^\n]*\n/gm,
    ""
  );

  result = result.replace(/\n{3,}/g, "\n\n");
  return result;
}

for (const file of fs.readdirSync(jsDir).filter((f) => f.endsWith(".js"))) {
  if (file === "navbar.js") continue;
  const filePath = path.join(jsDir, file);
  const original = fs.readFileSync(filePath, "utf8");
  const cleaned = clean(original);
  if (cleaned !== original) {
    fs.writeFileSync(filePath, cleaned);
    console.log("Stripped:", file);
  }
}
