<?php
header("Content-Type: application/json; charset=utf-8");

include("baglan.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["ok" => false, "message" => "Yalnızca POST isteği kabul edilir."]);
    exit;
}

$id = (int)($_POST["id"] ?? 0);
$favori = (int)($_POST["favori"] ?? -1);

if ($id <= 0 || !in_array($favori, [0, 1], true)) {
    http_response_code(400);
    echo json_encode(["ok" => false, "message" => "Geçersiz istek."]);
    exit;
}

$anket = dbFetchOne($db, "SELECT id FROM anketler WHERE id = ?", [$id]);
if (!$anket) {
    http_response_code(404);
    echo json_encode(["ok" => false, "message" => "Anket bulunamadı."]);
    exit;
}

$stmt = $db->prepare("UPDATE anketler SET favori = ? WHERE id = ?");
$stmt->execute([$favori, $id]);

echo json_encode(["ok" => true, "id" => $id, "favori" => $favori]);
