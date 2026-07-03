/**
 * personel_db alt tablolarını phpMyAdmin uyumlu tek SQL dosyasında birleştirir
 */
const fs = require("fs");
const path = require("path");

const dbDir = path.join(__dirname, "..", "db");

const tableFiles = [
  { file: "tum_veriler.sql", tables: ["haberler", "duyurular"] },
  { file: "etkinlikler.sql", tables: ["etkinlikler"] },
  { file: "videolar.sql", tables: ["videolar"] },
  { file: "sizden_gelenler.sql", tables: ["sizden_gelenler"] },
  { file: "personeller.sql", tables: ["personeller"] },
  { file: "vefat_bilgileri.sql", tables: ["vefat_bilgileri"] },
  { file: "dokumanlar.sql", tables: ["dokumanlar"] },
  { file: "yardimci_linkler.sql", tables: ["yardimci_linkler"] },
  { file: "anketler.sql", tables: ["anketler"] },
  { file: "haber_galeri.sql", tables: ["haber_galeri"] },
];

function cleanSqlText(block) {
  return block
    .replace(/\r\n/g, " ")
    .replace(/\\r\\n/g, " ")
    .replace(/\s{2,}/g, " ")
    .replace(/ ,/g, ",")
    .replace(/,\s*\)/g, ")");
}

function extractTableBlock(content, table) {
  const createRe = new RegExp(
    `CREATE TABLE(?: IF NOT EXISTS)? \`${table}\` \\([\\s\\S]*?\\) ENGINE=InnoDB[^;]*;`,
    "i"
  );
  const insertRe = new RegExp(
    `INSERT INTO \`${table}\` \\([\\s\\S]*?\\);`,
    "i"
  );
  const create = content.match(createRe);
  const insert = content.match(insertRe);
  if (!create) return "";
  let sql = create[0].replace("CREATE TABLE IF NOT EXISTS", "CREATE TABLE");
  if (insert) sql += "\n\n" + insert[0];
  return cleanSqlText(sql);
}

function tableAlterBlock(table, createSql) {
  if (/PRIMARY KEY/i.test(createSql)) {
    if (!/AUTO_INCREMENT/i.test(createSql)) {
      return `ALTER TABLE \`${table}\` MODIFY \`id\` int(11) NOT NULL AUTO_INCREMENT;\n`;
    }
    return "";
  }
  return (
    `ALTER TABLE \`${table}\` ADD PRIMARY KEY (\`id\`);\n` +
    `ALTER TABLE \`${table}\` MODIFY \`id\` int(11) NOT NULL AUTO_INCREMENT;\n`
  );
}

let out = `-- phpMyAdmin SQL Dump
-- Veritabanı: \`personel_db\`
-- Gebze Belediyesi Personel Portalı

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

CREATE DATABASE IF NOT EXISTS \`personel_db\` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE \`personel_db\`;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS \`portal_icerik\`;
DROP TABLE IF EXISTS \`haber_galeri\`;
DROP TABLE IF EXISTS \`anketler\`;
DROP TABLE IF EXISTS \`yardimci_linkler\`;
DROP TABLE IF EXISTS \`dokumanlar\`;
DROP TABLE IF EXISTS \`vefat_bilgileri\`;
DROP TABLE IF EXISTS \`personeller\`;
DROP TABLE IF EXISTS \`sizden_gelenler\`;
DROP TABLE IF EXISTS \`videolar\`;
DROP TABLE IF EXISTS \`etkinlikler\`;
DROP TABLE IF EXISTS \`duyurular\`;
DROP TABLE IF EXISTS \`haberler\`;
SET FOREIGN_KEY_CHECKS = 1;

`;

for (const entry of tableFiles) {
  const content = fs.readFileSync(path.join(dbDir, entry.file), "utf8");
  for (const table of entry.tables) {
    const block = extractTableBlock(content, table);
    if (block) {
      out += `\n-- --------------------------------------------------------\n`;
      out += `-- Tablo: \`${table}\`\n`;
      out += `-- --------------------------------------------------------\n\n`;
      out += block + "\n\n";
      const alter = tableAlterBlock(table, block);
      if (alter) out += alter + "\n";
    }
  }
}

out += `-- Tamamlandı\n`;

fs.writeFileSync(path.join(dbDir, "personel_db.sql"), out, "utf8");
console.log("personel_db.sql oluşturuldu (phpMyAdmin uyumlu)");
