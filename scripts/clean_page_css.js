/**
 * Sayfa CSS dosyalarından navbar/breadcrumb kurallarını çıkarır (git'ten başlar).
 */
const fs = require("fs");
const path = require("path");
const { execSync } = require("child_process");

const root = path.join(__dirname, "..");
const cssDir = path.join(root, "CSS");
const skip = new Set(["navbar.css", "breadcrumb.css", "footer.css", "brand.css", "responsive.css", "documents-shared.css"]);

const NAV_SELECTORS = [
  ".navbar",
  ".nav-container",
  ".nav-links",
  ".nav-dropdown",
  ".nav-dropdown-menu",
  ".nav-dropdown-toggle",
  ".profile-menu",
  ".profile-dropdown",
  ".profile-btn",
  ".profile-arrow",
  ".side-menu",
  ".menu-backdrop",
  ".mobile-menu-toggle",
  ".logo-img",
  ".logo-container",
  ".nav-left",
  ".nav-center",
  ".nav-right",
  ".breadcrumb-section",
  ".breadcrumb ",
];

function gitFile(rel) {
  return execSync(`git show HEAD:${rel}`, {
    cwd: root,
    encoding: "utf8",
    maxBuffer: 10 * 1024 * 1024,
  });
}

function stripRules(content) {
  let result = content;
  for (const sel of NAV_SELECTORS) {
    const escaped = sel.replace(/[.*+?^${}()|[\]\\]/g, "\\$&").trim();
    const re = new RegExp(
      `(?:^|\\n)${escaped}[^{,]*\\{[^}]*\\}`,
      "g"
    );
    result = result.replace(re, "\n");
  }
  // @media blocks that only contain nav rules - skip complex; brand.css handles overrides
  result = result.replace(/\n{3,}/g, "\n\n");
  return result;
}

for (const file of fs.readdirSync(cssDir).filter((f) => f.endsWith(".style.css"))) {
  if (skip.has(file)) continue;
  let content;
  try {
    content = gitFile(`CSS/${file}`);
  } catch {
    content = fs.readFileSync(path.join(cssDir, file), "utf8");
  }
  const cleaned = stripRules(content);
  fs.writeFileSync(path.join(cssDir, file), cleaned);
  console.log("CSS cleaned:", file);
}
