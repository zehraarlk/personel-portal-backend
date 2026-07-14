<?php
<<<<<<< HEAD
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../includes/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'message' => 'Yalnızca POST isteği kabul edilir.'], JSON_UNESCAPED_UNICODE);
    exit;
}

if (!csrfVerify($_POST['csrf_token'] ?? null)) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'message' => 'Geçersiz güvenlik doğrulaması.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$id = (int) ($_POST['id'] ?? 0);
$favori = (int) ($_POST['favori'] ?? -1);

if ($id <= 0 || !in_array($favori, [0, 1], true)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => 'Geçersiz istek.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$pdo = getPDO();

if (!dbTableExists($pdo, 'anketler')) {
    http_response_code(404);
    echo json_encode(['ok' => false, 'message' => 'Anket tablosu bulunamadı.'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $anket = dbFetchOne($pdo, 'SELECT id FROM anketler WHERE id = ?', [$id]);

    if (!$anket) {
        http_response_code(404);
        echo json_encode(['ok' => false, 'message' => 'Anket bulunamadı.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $stmt = $pdo->prepare('UPDATE anketler SET favori = ? WHERE id = ?');
    $stmt->execute([$favori, $id]);

    echo json_encode(['ok' => true, 'id' => $id, 'favori' => $favori], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    error_log('Anket favori hatasi: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Favori güncellenemedi.'], JSON_UNESCAPED_UNICODE);
}
=======
header("Content-Type: application/json; charset=utf-8");

include "baglan.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(405);
  echo json_encode(["ok" => false, "message" => "Yalnızca POST isteği kabul edilir."]);
  exit();
}

$id = (int) ($_POST["id"] ?? 0);
$favori = (int) ($_POST["favori"] ?? -1);

if ($id <= 0 || !in_array($favori, [0, 1], true)) {
  http_response_code(400);
  echo json_encode(["ok" => false, "message" => "Geçersiz istek."]);
  exit();
}

$anket = dbFetchOne($db, "SELECT id FROM anketler WHERE id = ?", [$id]);
if (!$anket) {
  http_response_code(404);
  echo json_encode(["ok" => false, "message" => "Anket bulunamadı."]);
  exit();
}

$stmt = $db->prepare("UPDATE anketler SET favori = ? WHERE id = ?");
$stmt->execute([$favori, $id]);

echo json_encode(["ok" => true, "id" => $id, "favori" => $favori]);
>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
