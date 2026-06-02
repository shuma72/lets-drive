<?php
session_start();
include_once 'db.php';

$error = '';
$success = '';

// Обработка РЕГИСТРАЦИИ
if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($link, trim($_POST['reg_username']));
    $password = trim($_POST['reg_password']);
    $role = $_POST['reg_role'];

    if (!empty($username) && !empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')";
        if (mysqli_query($link, $query)) {
            $success = "Регистрация успешна! Теперь вы можете войти.";
        } else {
            $error = "Ошибка: Пользователь с таким логином уже существует.";
        }
    } else {
        $error = "Заполните все поля регистрации.";
    }
}

// Обработка АВТОРИЗАЦИИ
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($link, trim($_POST['login_username']));
    $password = trim($_POST['login_password']);

    if (!empty($username) && !empty($password)) {
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($link, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] === 'admin') {
                    header("Location: lk_admin.php");
                    exit();
                } else if ($user['role'] === 'editor') {
                    header("Location: lk_editor.php");
                    exit();
                }
            } else {
                $error = "Неверный пароль.";
            }
        } else {
            $error = "Пользователь с таким логином не найден.";
        }
    } else {
        $error = "Заполните все поля для входа.";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Главная - Lets Drive</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
<div class="container">
<h1>Lets Drive</h1>
<nav>
<ul>
<li><a href="index.php">Главная</a></li>
<li><a href="news.html">Новости</a></li>
<li><a href="tips.html">Советы</a></li>
<li><a href="forum.html">Форум</a></li>
<li><a href="gallery.html">Галерея</a></li>
<li><a href="contacts.html">Контакты</a></li>
</ul>
</nav>
</div>
</header>

<main>
<section class="hero">
<div class="container">
<h2>Добро пожаловать на Lets Drive!</h2>
<p>Сообщество автолюбителей: актуальные новости, полезные советы, галерея и личный кабинет.</p>
</div>
</section>

<section class="auth-section">
<div class="container">
<?php if (isset($_SESSION['username'])): ?>
    <div class="welcome-box" style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); text-align: center; margin-top: 20px;">
        <p style="font-size: 1.1em; color: #333; margin-bottom: 20px;">Вы вошли как <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong> 
        (<?php echo ($_SESSION['role'] === 'admin') ? 'Администратор' : 'Редактор'; ?>).</p>
        <p style="display: flex; justify-content: center; align-items: center; gap: 25px; margin: 0;">
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="lk_admin.php" class="lk-link" style="color: #333; font-weight: bold; text-decoration: none; border-bottom: 2px solid #333; padding-bottom: 2px; transition: color 0.2s, border-color 0.2s;">В личный кабинет Администратора</a>
            <?php else: ?>
                <a href="lk_editor.php" class="lk-link" style="color: #333; font-weight: bold; text-decoration: none; border-bottom: 2px solid #333; padding-bottom: 2px; transition: color 0.2s, border-color 0.2s;">В личный кабинет Редактора</a>
            <?php endif; ?>
            
            <a href="logout.php" style="color: #666; text-decoration: none; font-weight: bold; border-bottom: 1px dashed #666; padding-bottom: 2px; transition: color 0.2s, border-color 0.2s;">Выйти</a>
        </p>
    </div>
    
    <style>
        .lk-link:hover {
            color: #0066cc !important;
            border-color: #0066cc !important;
        }
    </style>	
<?php else: ?>
    <h2>Авторизация и Доступ к Системе</h2>
    <p style="text-align:center; color:gray;">Для проверки разграничения прав зарегистрируйтесь или войдите.</p>
    
    <?php if($error): ?> <div class="msg-error" style="color:red; text-align:center; margin-bottom:15px; font-weight:bold;"><?php echo $error; ?></div> <?php endif; ?>
    <?php if($success): ?> <div class="msg-ok" style="color:green; text-align:center; margin-bottom:15px; font-weight:bold;"><?php echo $success; ?></div> <?php endif; ?>

    <div class="auth-container" style="display: flex; justify-content: space-around; flex-wrap: wrap; margin-top: 20px;">
        <div class="auth-box">
            <h3>Вход в кабинет</h3>
            <form action="index.php" method="POST">
                <input type="text" name="login_username" placeholder="Ваш логин" required>
                <input type="password" name="login_password" placeholder="Ваш пароль" required>
                <button type="submit" name="login">Войти</button>
            </form>
        </div>

        <div class="auth-box">
            <h3>Регистрация</h3>
            <form action="index.php" method="POST">
                <input type="text" name="reg_username" placeholder="Придумайте логин" required>
                <input type="password" name="reg_password" placeholder="Придумайте пароль" required>
                <label style="margin-top: 5px; display:block; font-size: 0.9em; color: #555;">Выберите группу доступа:</label>
                <select name="reg_role">
                    <option value="admin">Группа 1 (Администратор — просмотр базы)</option>
                    <option value="editor">Группа 2 (Редактор — отправка контента)</option>
                </select>
                <button type="submit" name="register" style="background: #28a745;">Зарегистрироваться</button>
            </form>
        </div>
    </div>
<?php endif; ?>
</div>
</section>

<section class="latest-news">
<div class="container">
<h2>Последние новости</h2>
<p>Здесь будут отображаться последние новости автомобильного мира:</p>
<article>
<h3><a href="https://www.autonews.ru/news/693c10609a7947b2454442e0" target="_blank">Праворульные автомобили в России могут столкнуться с трудностями при постановке на учёт</a></h3>
</article>
</div>
</section>
</main>

<footer>
<div class="container">
<p>&copy; 2025 Lets Drive. Все права защищены.</p>
</div>
</footer>
<script src="js/main.js"></script>
</body>
</html>