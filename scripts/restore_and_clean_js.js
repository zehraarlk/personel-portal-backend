/**
 * Git'ten JS geri yükler; navbar bloklarını güvenli çıkarır.
 */
const fs = require("fs");
const path = require("path");
const { execSync } = require("child_process");

const root = path.join(__dirname, "..");
const jsDir = path.join(root, "JS");

function gitFile(relPath) {
  return execSync(`git show HEAD:${relPath.replace(/\\/g, "/")}`, {
    cwd: root,
    encoding: "utf8",
    maxBuffer: 10 * 1024 * 1024,
  });
}

const PAGE_CONTENT_MARKERS = [
  "// --- GALERİ",
  "// ========== ARAMA",
  "// Search functionality",
  "// ---- Arama",
  "// --- ARAMA",
  "let filteredData",
  'const searchInput = document.getElementById("searchInput")',
  "updateTotalCount();",
  "renderNews();",
  'document.querySelectorAll(".birthday-card")',
  "const filterTabs",
  "loadVideos(",
  "initPage(",
  "// Initialize",
  "const cards =",
  "// DOM Elements",
];

function findFirstMarker(text, fromIndex = 0) {
  let best = -1;
  for (const marker of PAGE_CONTENT_MARKERS) {
    const i = text.indexOf(marker, fromIndex);
    if (i !== -1 && (best === -1 || i < best)) best = i;
  }
  return best;
}

function stripNavbarFromDomReady(content) {
  const needle = 'document.addEventListener("DOMContentLoaded", function () {';
  const start = content.indexOf(needle);
  if (start === -1) return content;

  const bodyStart = start + needle.length;
  const afterOpen = content.slice(bodyStart);
  const navSignals = /const profileBtn|const isHoverable|console\.log\("Sayfa yüklendi/;
  if (!navSignals.test(afterOpen.slice(0, 800))) return content;

  const markerAt = findFirstMarker(afterOpen);
  if (markerAt === -1) return content;

  const before = content.slice(0, bodyStart);
  const rest = afterOpen.slice(markerAt);
  return before + "\n\n  " + rest;
}

function stripNavbarFromSetup(content) {
  const needle = "function setupEventListeners() {";
  const start = content.indexOf(needle);
  if (start === -1) return content;

  const bodyStart = start + needle.length;
  const afterOpen = content.slice(bodyStart);
  if (!/Gerekli Bütün HTML|MOBİL YAN MENÜ|Profil/.test(afterOpen.slice(0, 500))) {
    return content;
  }

  const markerAt = findFirstMarker(afterOpen);
  if (markerAt === -1) return content;

  const before = content.slice(0, bodyStart);
  const rest = afterOpen.slice(markerAt);
  return before + "\n  " + rest;
}

function removeProfileMenuInit(content) {
  return content.replace(
    /if\s*\(\s*!window\.__profileMenuInit__\s*\)\s*\{[\s\S]*?\n\}\s*\n?/g,
    ""
  );
}

for (const file of fs.readdirSync(jsDir).filter((f) => f.endsWith(".js"))) {
  if (file === "navbar.js" || file.startsWith("_orig")) continue;
  let content;
  try {
    content = gitFile(`JS/${file}`);
  } catch {
    continue;
  }

  let cleaned = content;
  cleaned = removeProfileMenuInit(cleaned);
  cleaned = stripNavbarFromSetup(cleaned);
  cleaned = stripNavbarFromDomReady(cleaned);
  cleaned = cleaned.replace(/\n{3,}/g, "\n\n");

  fs.writeFileSync(path.join(jsDir, file), cleaned);
  console.log("Processed:", file);
}
