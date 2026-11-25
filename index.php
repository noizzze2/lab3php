<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Если пользователь меняет настройки
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_settings'])) {
    $bg = $_POST['bg_color'];
    $font = $_POST['font_color'];
    
    $stmt = $pdo->prepare("UPDATE users SET bg_color = ?, font_color = ? WHERE id = ?");
    $stmt->execute([$bg, $font, $_SESSION['user_id']]);
    
    // Обновляем cookie
    setcookie('bg_color', $bg, time() + 86400 * 30, '/');
    setcookie('font_color', $font, time() + 86400 * 30, '/');
    header("Location: index.php");
    exit;
}

// Получаем текущие настройки из cookie или базы
$bg = $_COOKIE['bg_color'] ?? '#ffffff';
$font = $_COOKIE['font_color'] ?? '#000000';
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { background-color: <?= $bg ?>; color: <?= $font ?>; font-family: Arial; }
    </style>
</head>
<body>
    <h2>Добро пожаловать!</h2>
    <p>Это ваша персональная страница.</p>
    
    <hr>
    <h3>Настройки внешнего вида</h3>
    <form method="POST">
        Цвет фона: <input type="color" name="bg_color" value="<?= $bg ?>"><br><br>
        Цвет шрифта: <input type="color" name="font_color" value="<?= $font ?>"><br><br>
        <button type="submit" name="update_settings">Сохранить</button>
    </form>
    <br>
    <a href="logout.php">Выйти</a>
</body>
</html>