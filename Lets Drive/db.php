<?php
$host = 'localhost';
$db   = 'lets-drive';
$user = 'lets-drive';
$pass = 'YOUR_PASSWORD_HERE';

$link = mysqli_connect($host, $user, $pass, $db);

if (!$link) {
    die("Ошибка подключения к БД: " . mysqli_connect_error());
}

mysqli_set_charset($link, "utf8mb4");
?>