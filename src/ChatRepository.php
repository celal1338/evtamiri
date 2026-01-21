<?php

declare(strict_types=1);

final class ChatRepository
{
    public function __construct(private \PDO $pdo)
    {
    }

    public function listRooms(): array
    {
        $stmt = $this->pdo->query('SELECT id, name, created_at FROM chat_rooms ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public function createRoom(string $name): array
    {
        $stmt = $this->pdo->prepare('INSERT INTO chat_rooms (name) VALUES (:name)');
        $stmt->execute(['name' => $name]);

        return [
            'id' => (int) $this->pdo->lastInsertId(),
            'name' => $name,
        ];
    }

    public function listMessages(int $roomId, int $limit = 50): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, room_id, author_name, body, created_at FROM chat_messages WHERE room_id = :room_id ORDER BY created_at DESC LIMIT :limit'
        );
        $stmt->bindValue('room_id', $roomId, \PDO::PARAM_INT);
        $stmt->bindValue('limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return array_reverse($stmt->fetchAll());
    }

    public function createMessage(int $roomId, string $authorName, string $body): array
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO chat_messages (room_id, author_name, body) VALUES (:room_id, :author_name, :body)'
        );
        $stmt->execute([
            'room_id' => $roomId,
            'author_name' => $authorName,
            'body' => $body,
        ]);

        return [
            'id' => (int) $this->pdo->lastInsertId(),
            'room_id' => $roomId,
            'author_name' => $authorName,
            'body' => $body,
        ];
    }
}
