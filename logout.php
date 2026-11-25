<?php
session_start();
session_destroy();
// Удаляем куки
setcookie('auth_token', '', time() - 3600, '/');
setcookie('bg_color', '', time() - 3600, '/');
setcookie('font_color', '', time() - 3600, '/');
header("Location: login.php");
exit;
?>