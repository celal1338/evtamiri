# evtamiri

Profesyonel çoklu veya birebir chat altyapısı için PHP + PDO örneği.

## Kurulum

1. Veritabanını oluşturun ve şemayı çalıştırın:

```sql
CREATE DATABASE chat_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
SOURCE schema.sql;
```

2. `config/database.php` içindeki DSN, kullanıcı adı ve şifre bilgilerini güncelleyin ya da çevresel değişkenlerle tanımlayın:

```bash
export CHAT_DSN='mysql:host=127.0.0.1;dbname=chat_app;charset=utf8mb4'
export CHAT_DB_USER='chat_user'
export CHAT_DB_PASS='secret'
```

3. Uygulamayı çalıştırın:

```bash
php -S 0.0.0.0:8000 -t public
```

## API Özet

- `GET /api/rooms.php`: Oda listesini getirir.
- `POST /api/rooms.php`: `{ "name": "Destek" }` ile yeni oda oluşturur.
- `GET /api/messages.php?room_id=1`: Oda mesajlarını getirir.
- `POST /api/messages.php`: `{ "room_id": 1, "author_name": "Ayşe", "body": "Merhaba" }` ile mesaj gönderir.
