<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'editor') {
    die("Доступ ограничен. Страница доступна только Группе 2.");
}

$notification = '';
if (isset($_POST['submit_article'])) {
    $notification = "Материал успешно отправлен на модерацию главному редактору на email: andryxa.rulit22@mail.ru";
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Кабинет Редактора - Lets Drive</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<header><div class="container"><h1>Lets Drive — Редакция</h1><nav><ul><li><a href="index.php">На главную</a></li><li><a href="logout.php">Выйти</a></li></ul></nav></div></header>
<main>
<div class="container" style="padding: 20px 0;">
    <h2>Кабинет Редактора (Группа 2)</h2>
    <p>Приветствуем, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!</p>

    <?php if($notification): ?> <div class="msg-ok" style="background:#e0f7fa; padding:10px; border-left:5px solid #00acc1; margin-bottom:15px; color:#006064; font-weight:bold;"><?php echo $notification; ?></div> <?php endif; ?>

    <h3>Предложить материал к публикации:</h3>
    <form action="lk_editor.php" method="POST" class="editor-form" style="background:#fff; padding:20px; border-radius:6px; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
        <div style="margin-bottom:15px;">
            <label style="display:block; margin-bottom:5px; font-weight:bold;">Тема статьи:</label>
            <input type="text" name="art_title" placeholder="Введите заголовок статьи" required style="width:100%; padding:8px; box-sizing:border-box;">
        </div>
        <div style="margin-bottom:15px;">
            <label style="display:block; margin-bottom:5px; font-weight:bold;">Текст материала:</label>
            <textarea name="art_text" rows="6" placeholder="Напишите текст вашей автомобильной новости или совета..." required style="width:100%; padding:8px; box-sizing:border-box; font-family:Arial, sans-serif;"></textarea>
        </div>
        <button type="submit" name="submit_article" style="background:#0066cc; color:#fff; border:none; padding:10px 20px; border-radius:4px; cursor:pointer; font-weight:bold;">Отправить на модерацию</button>
    </form>
</div>
</main>
<footer><div class="container"><p>&copy; 2025 Lets Drive. Все права защищены.</p></div></footer>
<script src="js/main.js"></script>
</body>
</html>