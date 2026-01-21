<?php

declare(strict_types=1);

require __DIR__ . '/../../src/Database.php';
require __DIR__ . '/../../src/ChatRepository.php';

header('Content-Type: application/json; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$repository = new ChatRepository(Database::connection());

if ($method === 'GET') {
    echo json_encode(['rooms' => $repository->listRooms()], JSON_THROW_ON_ERROR);
    exit;
}

if ($method === 'POST') {
    $payload = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
    $name = trim((string) ($payload['name'] ?? ''));

    if ($name === '') {
        http_response_code(422);
        echo json_encode(['error' => 'Oda adı gerekli.'], JSON_THROW_ON_ERROR);
        exit;
    }

    $room = $repository->createRoom($name);
    echo json_encode(['room' => $room], JSON_THROW_ON_ERROR);
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'İzin verilmeyen istek.'], JSON_THROW_ON_ERROR);
