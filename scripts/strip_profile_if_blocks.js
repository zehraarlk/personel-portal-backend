/**
 * Yalnızca if (profileBtn && profileMenu) ve __profileMenuInit__ bloklarını kaldırır.
 */
const fs = require("fs");
const path = require("path");

const jsDir = path.join(__dirname, "..", "JS");

function removeBraceBlock(content, openBraceIndex) {
  let depth = 0;
  for (let i = openBraceIndex; i < content.length; i++) {
    if (content[i] === "{") depth++;
    else if (content[i] === "}") {
      depth--;
      if (depth === 0) return content.slice(0, openBraceIndex) + content.slice(i + 1);
    }
  }
  return content;
}

function removeIfBlock(content, ifNeedle) {
  let result = content;
  let safety = 0;
  while (safety++ < 30) {
    const idx = result.indexOf(ifNeedle);
    if (idx === -1) break;
    const lineStart = result.lastIndexOf("\n", idx) + 1;
    const before = result.slice(0, lineStart);
    const fromIf = result.slice(idx);
    const brace = fromIf.indexOf("{");
    if (brace === -1) break;
    const removed = removeBraceBlock(fromIf, brace);
    result = before + removed;
  }
  return result;
}

for (const file of fs.readdirSync(jsDir).filter((f) => f.endsWith(".js"))) {
  if (file === "navbar.js") continue;
  const filePath = path.join(jsDir, file);
  let content = fs.readFileSync(filePath, "utf8");
  const original = content;

  content = removeIfBlock(content, "if (!window.__profileMenuInit__)");
  content = removeIfBlock(content, "if (profileBtn && profileMenu)");

  if (content !== original) {
    fs.writeFileSync(filePath, content);
    console.log("Removed profile if-blocks:", file);
  }
}
