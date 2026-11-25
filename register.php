<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $bg = $_POST['bg_color'] ?? '#ffffff';
    $font = $_POST['font_color'] ?? '#000000';

    $stmt = $pdo->prepare("INSERT INTO users (login, password, bg_color, font_color) VALUES (?, ?, ?, ?)");
    try {
        $stmt->execute([$login, $pass, $bg, $font]);
        echo "Регистрация успешна! <a href='login.php'>Войти</a>";
        exit;
    } catch (Exception $e) {
        $error = "Ошибка: логин уже существует.";
    }
}
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Регистрация</h2>
    <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="POST">
        Логин: <input type="text" name="login" required><br><br>
        Пароль: <input type="password" name="password" required><br><br>
        Цвет фона: <input type="color" name="bg_color" value="#ffffff"><br><br>
        Цвет шрифта: <input type="color" name="font_color" value="#000000"><br><br>
        <button type="submit">Зарегистрироваться</button>
    </form>
    <br><a href="login.php">Уже есть аккаунт? Войти</a>
</body>
</html>