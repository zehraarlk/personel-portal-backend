<?php
header("Content-Type: application/json; charset=utf-8");

include("baglan.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["ok" => false, "message" => "Yalnızca POST isteği kabul edilir."]);
    exit;
}

$id = (int)($_POST["id"] ?? 0);

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(["ok" => false, "message" => "Geçersiz video id."]);
    exit;
}

try {
    if (!dbDeleteVideo($db, $id)) {
        http_response_code(404);
        echo json_encode(["ok" => false, "message" => "Video bulunamadı."]);
        exit;
    }

    echo json_encode(["ok" => true, "message" => "Video silindi, id numaraları yeniden sıralandı."]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(["ok" => false, "message" => "Silme işlemi başarısız."]);
}
