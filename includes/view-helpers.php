<?php
declare(strict_types=1);

function dbEnsureIcerikIzlemeleri(PDO $pdo): void
{
    try {
        $pdo->exec(
            'CREATE TABLE IF NOT EXISTS `icerik_izlemeleri` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `tablo` varchar(64) NOT NULL,
                `kayit_id` int(11) NOT NULL,
                `izleyici` varchar(96) NOT NULL,
                `olusturma_tarihi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uq_icerik_izleme` (`tablo`, `kayit_id`, `izleyici`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci'
        );
    } catch (Throwable) {
        // tablo zaten var veya yetki yok
    }
}

function viewViewerKey(): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!empty($_SESSION['personel_id'])) {
        return 'personel:' . (int) $_SESSION['personel_id'];
    }

    $cookieName = 'pp_viewer';
    $token = $_COOKIE[$cookieName] ?? '';

    if (!is_string($token) || !preg_match('/^[a-f0-9]{32}$/', $token)) {
        $token = bin2hex(random_bytes(16));
        setcookie($cookieName, $token, [
            'expires'  => time() + 60 * 60 * 24 * 365,
            'path'     => '/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        $_COOKIE[$cookieName] = $token;
    }

    return 'guest:' . $token;
}

/**
 * @return array{count:int,increased:bool}
 */
function dbBumpUniqueView(PDO $pdo, string $table, int $id, string $column = 'view'): array
{
    $allowed = [
        'etkinlikler'            => 'view',
        'anasayfa_duyurular'     => 'view',
        'duyurular'              => 'view',
        'sizden_gelenler'        => 'goruntulenme',
        'haberler'               => 'view',
        'etkinlikler_duyurular'  => '',
    ];

    if (!array_key_exists($table, $allowed) || $id <= 0) {
        return ['count' => 0, 'increased' => false];
    }

    $column = $allowed[$table];
    dbEnsureIcerikIzlemeleri($pdo);

    $viewer = viewViewerKey();
    $increased = false;

    try {
        $ins = $pdo->prepare(
            'INSERT IGNORE INTO icerik_izlemeleri (tablo, kayit_id, izleyici) VALUES (?, ?, ?)'
        );
        $ins->execute([$table, $id, $viewer]);
        $increased = $ins->rowCount() > 0;

        if ($increased && $column !== '') {
            $pdo->prepare("UPDATE `{$table}` SET `{$column}` = COALESCE(`{$column}`, 0) + 1 WHERE id = ?")
                ->execute([$id]);
        }
    } catch (Throwable) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['content_views']) || !is_array($_SESSION['content_views'])) {
            $_SESSION['content_views'] = [];
        }

        $key = $table . ':' . $id . ':' . $viewer;

        if (empty($_SESSION['content_views'][$key])) {
            try {
                if ($column !== '') {
                    $pdo->prepare("UPDATE `{$table}` SET `{$column}` = COALESCE(`{$column}`, 0) + 1 WHERE id = ?")
                        ->execute([$id]);
                }
                $_SESSION['content_views'][$key] = 1;
                $increased = true;
            } catch (Throwable) {
                // geç
            }
        }
    }

    if ($column !== '') {
        $row = dbFetchOne($pdo, "SELECT `{$column}` AS c FROM `{$table}` WHERE id = ?", [$id]);
        $count = (int) ($row['c'] ?? 0);
    } else {
        $row = dbFetchOne(
            $pdo,
            'SELECT COUNT(*) AS c FROM icerik_izlemeleri WHERE tablo = ? AND kayit_id = ?',
            [$table, $id]
        );
        $count = (int) ($row['c'] ?? 0);
    }

    return [
        'count'     => $count,
        'increased' => $increased,
    ];
}
