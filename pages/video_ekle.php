<?php
header("Content-Type: application/json; charset=utf-8");

include("baglan.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["ok" => false, "message" => "Yalnızca POST isteği kabul edilir."]);
    exit;
}

$youtubeId = trim((string)($_POST["youtube_id"] ?? ""));
$baslik    = trim((string)($_POST["baslik"] ?? ""));
$aciklama  = trim((string)($_POST["aciklama"] ?? ""));
$kategori  = trim((string)($_POST["kategori"] ?? "duyurular"));
$sure      = trim((string)($_POST["sure"] ?? "00:00"));

if ($youtubeId === "" || $baslik === "") {
    http_response_code(400);
    echo json_encode(["ok" => false, "message" => "youtube_id ve baslik zorunludur."]);
    exit;
}

$existing = dbFetchOne($db, "SELECT id FROM videolar WHERE youtube_id = ?", [$youtubeId]);
if ($existing) {
    http_response_code(409);
    echo json_encode(["ok" => false, "message" => "Bu YouTube videosu zaten kayıtlı."]);
    exit;
}

try {
    $id = dbInsertVideo($db, [
        "youtube_id" => $youtubeId,
        "baslik"     => $baslik,
        "aciklama"   => $aciklama,
        "kategori"   => $kategori,
        "sure"       => $sure,
    ]);

    echo json_encode([
        "ok"      => true,
        "id"      => $id,
        "message" => "Video eklendi ve 1. sıraya alındı.",
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(["ok" => false, "message" => "Video eklenemedi."]);
}
