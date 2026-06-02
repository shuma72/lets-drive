// Онлайн пользователи (локальный счётчик сессий)
const onlineEl = document.createElement('div');
onlineEl.id = 'online-users';
onlineEl.style.position = 'fixed';
onlineEl.style.bottom = '10px';
onlineEl.style.right = '10px';
onlineEl.style.background = 'rgba(0,0,0,0.7)';
onlineEl.style.color = '#fff';
onlineEl.style.padding = '8px 12px';
onlineEl.style.borderRadius = '5px';
onlineEl.style.fontSize = '0.9em';
onlineEl.style.zIndex = '9999'; // Чтобы плашка была поверх всего
document.body.appendChild(onlineEl);

// Читаем старое значение, если там 0 или пусто — принудительно ставим 1, так как мы уже зашли
let users = parseInt(localStorage.getItem('onlineUsers')) || 0;
users++;
if (users < 1) users = 1;

localStorage.setItem('onlineUsers', users);
onlineEl.textContent = `Пользователей на сайте: ${users}`;

window.addEventListener('beforeunload', () => {
    let current = parseInt(localStorage.getItem('onlineUsers')) || 1;
    current = current - 1;
    if (current < 0) current = 0; // Не даем уходить в отрицательные числа
    localStorage.setItem('onlineUsers', current);
});
// =======================
// Блокировка правого клика
// =======================
document.addEventListener('contextmenu', function(e) {
    e.preventDefault();
    alert("Копирование контента запрещено!");
});

// =======================
// Блокировка выделения текста
// =======================
document.addEventListener('selectstart', function(e) {
    e.preventDefault();
});

// =======================
// Блокировка перетаскивания изображений
// =======================
document.addEventListener('dragstart', function(e) {
    e.preventDefault();
});

// =======================
// Блокировка горячих клавиш Ctrl+C, Ctrl+S, Ctrl+U, Ctrl+Shift+I
// =======================
document.addEventListener('keydown', function(e) {
    if (
        (e.ctrlKey && e.key === 'c') ||      // Ctrl+C
        (e.ctrlKey && e.key === 's') ||      // Ctrl+S
        (e.ctrlKey && e.key === 'u') ||      // Ctrl+U (исходный код)
        (e.ctrlKey && e.shiftKey && e.key === 'I') // Ctrl+Shift+I (инспектор)
    ) {
        e.preventDefault();
        alert("Действие запрещено!");
    }
});
