<?php
require 'db.php';
session_start();

// Автоматический вход через Cookie
if (!isset($_SESSION['user_id']) && isset($_COOKIE['auth_token'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_COOKIE['auth_token']]);
    $user = $stmt->fetch();
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        setcookie('bg_color', $user['bg_color'], time() + 86400 * 30, '/');
        setcookie('font_color', $user['font_color'], time() + 86400 * 30, '/');
        header("Location: index.php");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        // Сохраняем токен в cookie на 30 дней
        setcookie('auth_token', $user['id'], time() + 86400 * 30, '/');
        setcookie('bg_color', $user['bg_color'], time() + 86400 * 30, '/');
        setcookie('font_color', $user['font_color'], time() + 86400 * 30, '/');
        header("Location: index.php");
        exit;
    } else {
        $error = "Неверный логин или пароль.";
    }
}
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Авторизация</h2>
    <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="POST">
        Логин: <input type="text" name="login" required><br><br>
        Пароль: <input type="password" name="password" required><br><br>
        <button type="submit">Войти</button>
    </form>
    <br><a href="register.php">Нет аккаунта? Регистрация</a>
</body>
</html>