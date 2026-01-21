<?php

declare(strict_types=1);

require __DIR__ . '/../../src/Database.php';
require __DIR__ . '/../../src/ChatRepository.php';

header('Content-Type: application/json; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$repository = new ChatRepository(Database::connection());

if ($method === 'GET') {
    $roomId = (int) ($_GET['room_id'] ?? 0);
    if ($roomId <= 0) {
        http_response_code(422);
        echo json_encode(['error' => 'Geçerli oda seçin.'], JSON_THROW_ON_ERROR);
        exit;
    }

    $messages = $repository->listMessages($roomId);
    echo json_encode(['messages' => $messages], JSON_THROW_ON_ERROR);
    exit;
}

if ($method === 'POST') {
    $payload = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
    $roomId = (int) ($payload['room_id'] ?? 0);
    $author = trim((string) ($payload['author_name'] ?? ''));
    $body = trim((string) ($payload['body'] ?? ''));

    if ($roomId <= 0 || $author === '' || $body === '') {
        http_response_code(422);
        echo json_encode(['error' => 'Oda, isim ve mesaj zorunludur.'], JSON_THROW_ON_ERROR);
        exit;
    }

    $message = $repository->createMessage($roomId, $author, $body);
    echo json_encode(['message' => $message], JSON_THROW_ON_ERROR);
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'İzin verilmeyen istek.'], JSON_THROW_ON_ERROR);
