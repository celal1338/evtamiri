<?php

declare(strict_types=1);

return [
    'dsn' => getenv('CHAT_DSN') ?: 'mysql:host=127.0.0.1;dbname=chat_app;charset=utf8mb4',
    'username' => getenv('CHAT_DB_USER') ?: 'chat_user',
    'password' => getenv('CHAT_DB_PASS') ?: 'secret',
];
