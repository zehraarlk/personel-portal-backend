/**
 * Sayfa CSS dosyalarından breadcrumb ve doküman grid çakışmalarını temizler.
 */
const fs = require("fs");
const path = require("path");

const cssDir = path.join(__dirname, "..", "CSS");
const docFiles = new Set([
  "protokol.style.css",
  "dokumanlar.style.css",
  "mevzuat.style.css",
  "egitim.style.css",
]);

function stripBreadcrumbRules(content) {
  const rules = [
    /\.breadcrumb-section\s+\.container\s*\{[\s\S]*?\}\s*/g,
    /\.breadcrumb-section\s*\{[\s\S]*?\}\s*/g,
    /\.breadcrumb-container\s*\{[\s\S]*?\}\s*/g,
    /\.breadcrumb-left\s*\{[\s\S]*?\}\s*/g,
    /\.breadcrumb-item\s*\+\s*\.breadcrumb-item::before\s*\{[\s\S]*?\}\s*/g,
    /\.breadcrumb-item\s+a:hover\s*\{[\s\S]*?\}\s*/g,
    /\.breadcrumb-item\s+a\s*\{[\s\S]*?\}\s*/g,
    /\.breadcrumb-item\.active\s*\{[\s\S]*?\}\s*/g,
    /\.breadcrumb-item\s*\{[\s\S]*?\}\s*/g,
    /\.breadcrumb\s*\{[\s\S]*?\}\s*/g,
  ];

  let result = content;
  for (const re of rules) {
    result = result.replace(re, "");
  }

  result = result.replace(/\s*\.documents-grid\s*\{[^}]*\}\s*/g, "\n");
  result = result.replace(/\n{3,}/g, "\n\n");
  return result;
}

function stripDocumentLayoutConflicts(content) {
  let result = content;

  result = result.replace(/\.documents-grid\s*\{[\s\S]*?\}\s*/g, "");

  result = result.replace(
    /@media\s*\(max-width:\s*992px\)\s*\{\s*\.document-card\s*\{[^}]*\}\s*\}\s*/g,
    ""
  );
  result = result.replace(
    /@media\s*\(max-width:\s*576px\)\s*\{\s*\.document-card\s*\{[^}]*flex:[^}]*\}\s*\}\s*/g,
    ""
  );

  result = result.replace(
    /(\.document-card\s*\{)([^}]*)(\})/g,
    (match, open, body, close) => {
      const cleaned = body
        .replace(/\s*flex:\s*[^;]+;/g, "")
        .replace(/\s*max-width:\s*calc[^;]+;/g, "")
        .replace(/\s*margin-top:\s*20px;/g, "");
      return open + cleaned + close;
    }
  );

  result = result.replace(/\n{3,}/g, "\n\n");
  return result;
}

const files = fs.readdirSync(cssDir).filter((f) => f.endsWith(".style.css"));

for (const file of files) {
  const filePath = path.join(cssDir, file);
  let content = fs.readFileSync(filePath, "utf8");
  content = stripBreadcrumbRules(content);

  if (docFiles.has(file)) {
    content = stripDocumentLayoutConflicts(content);
  }

  fs.writeFileSync(filePath, content);
  console.log("Cleaned:", file);
}
