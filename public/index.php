<?php

declare(strict_types=1);

?><!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profesyonel Chat (PDO)</title>
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
    <div class="app">
        <aside class="sidebar">
            <h1>Chat Odaları</h1>
            <form id="room-form" class="panel">
                <label>
                    Oda Adı
                    <input type="text" name="name" placeholder="Örn. Destek" required>
                </label>
                <button type="submit">Yeni Oda</button>
            </form>
            <div id="rooms" class="rooms"></div>
        </aside>

        <main class="chat">
            <header class="chat-header">
                <div>
                    <h2 id="room-title">Oda seçin</h2>
                    <p id="room-subtitle">Mesajlar burada görünecek.</p>
                </div>
                <button id="refresh">Yenile</button>
            </header>

            <section id="messages" class="messages"></section>

            <form id="message-form" class="composer">
                <input type="text" name="author_name" placeholder="Adınız" required>
                <input type="text" name="body" placeholder="Mesajınızı yazın" required>
                <button type="submit">Gönder</button>
            </form>
        </main>
    </div>

    <script src="/assets/app.js"></script>
</body>
</html>
