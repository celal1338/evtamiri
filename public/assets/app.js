const roomsEl = document.getElementById('rooms');
const messagesEl = document.getElementById('messages');
const roomTitleEl = document.getElementById('room-title');
const roomSubtitleEl = document.getElementById('room-subtitle');
const roomForm = document.getElementById('room-form');
const messageForm = document.getElementById('message-form');
const refreshButton = document.getElementById('refresh');

let activeRoomId = null;

const api = {
    rooms: '/api/rooms.php',
    messages: '/api/messages.php',
};

const formatTimestamp = (value) => {
    if (!value) return '';
    const date = new Date(value.replace(' ', 'T'));
    return new Intl.DateTimeFormat('tr-TR', {
        hour: '2-digit',
        minute: '2-digit',
        day: '2-digit',
        month: 'short',
    }).format(date);
};

const renderRooms = (rooms) => {
    roomsEl.innerHTML = '';

    if (rooms.length === 0) {
        roomsEl.innerHTML = '<p class="empty">Henüz oda yok.</p>';
        return;
    }

    rooms.forEach((room) => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = `room ${room.id === activeRoomId ? 'active' : ''}`;
        button.textContent = room.name;
        button.addEventListener('click', () => selectRoom(room));
        roomsEl.appendChild(button);
    });
};

const renderMessages = (messages) => {
    messagesEl.innerHTML = '';

    if (messages.length === 0) {
        messagesEl.innerHTML = '<p class="empty">Bu odada henüz mesaj yok.</p>';
        return;
    }

    messages.forEach((message) => {
        const wrapper = document.createElement('article');
        wrapper.className = 'message';

        const header = document.createElement('div');
        header.className = 'message-header';
        header.innerHTML = `<strong>${message.author_name}</strong><span>${formatTimestamp(message.created_at)}</span>`;

        const body = document.createElement('p');
        body.textContent = message.body;

        wrapper.appendChild(header);
        wrapper.appendChild(body);
        messagesEl.appendChild(wrapper);
    });

    messagesEl.scrollTop = messagesEl.scrollHeight;
};

const loadRooms = async () => {
    const response = await fetch(api.rooms);
    const data = await response.json();
    renderRooms(data.rooms || []);
};

const loadMessages = async () => {
    if (!activeRoomId) return;
    const response = await fetch(`${api.messages}?room_id=${activeRoomId}`);
    const data = await response.json();
    renderMessages(data.messages || []);
};

const selectRoom = (room) => {
    activeRoomId = room.id;
    roomTitleEl.textContent = room.name;
    roomSubtitleEl.textContent = 'Aktif oda';
    loadRooms();
    loadMessages();
};

roomForm.addEventListener('submit', async (event) => {
    event.preventDefault();
    const formData = new FormData(roomForm);
    const payload = { name: formData.get('name') };

    const response = await fetch(api.rooms, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
    });

    if (!response.ok) {
        alert('Oda oluşturulamadı.');
        return;
    }

    const data = await response.json();
    roomForm.reset();
    await loadRooms();
    selectRoom(data.room);
});

messageForm.addEventListener('submit', async (event) => {
    event.preventDefault();
    if (!activeRoomId) {
        alert('Önce bir oda seçin.');
        return;
    }

    const formData = new FormData(messageForm);
    const payload = {
        room_id: activeRoomId,
        author_name: formData.get('author_name'),
        body: formData.get('body'),
    };

    const response = await fetch(api.messages, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
    });

    if (!response.ok) {
        alert('Mesaj gönderilemedi.');
        return;
    }

    messageForm.reset();
    await loadMessages();
});

refreshButton.addEventListener('click', () => {
    loadRooms();
    loadMessages();
});

loadRooms();
