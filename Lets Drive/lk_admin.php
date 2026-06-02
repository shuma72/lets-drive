<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Доступ ограничен. Страница доступна только Группе 1.");
}

include_once 'db.php';

$query = "SELECT id, username, role FROM users ORDER BY id DESC";
$result = mysqli_query($link, $query);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Панель Администратора - Lets Drive</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<header><div class=\"container\"><h1>Lets Drive — Админка</h1><nav><ul><li><a href="index.php">На главную</a></li><li><a href="logout.php">Выйти</a></li></ul></nav></div></header>
<main>
<div class="container" style="padding: 20px 0;">
    <h2>Панель Администратора (Группа 1)</h2>
    <p>Вы вошли под именем: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>

    <h3>Список зарегистрированных пользователей (из MySQL):</h3>
    <table class="admin-table">
        <thead>
            <tr><th>ID</th><th>Логин</th><th>Группа</th></tr>
        </thead>
        <tbody>
            <?php while($user_row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $user_row['id']; ?></td>
                <td><?php echo htmlspecialchars($user_row['username']); ?></td>
                <td><?php echo ($user_row['role'] == 'admin') ? 'Группа 1 (Admin)' : 'Группа 2 (Editor)'; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h3>Статистика посещаемости проекта:</h3>
    <div class="stats-box">
        <p>📊 <strong>Счетчик localStorage:</strong> <span id="session-count" style="font-weight:bold; color:#0066cc;">извлечение...</span></p>
        <p>🌐 <strong>Внешние счетчики:</strong> На сайте функционируют коды отслеживания Яндекс.Метрика и Google Analytics.</p>
    </div>
</div>
</main>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Если админка открыта, как минимум 1 вкладка точно активна
    let count = parseInt(localStorage.getItem('onlineUsers')) || 1;
    if (count < 1) count = 1; 
    document.getElementById('session-count').textContent = count + " активных вкладок/сессий в браузере";
});
</script>
</body>
</html>