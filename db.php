<?php
$host = 'MySQL-8.0'; // OpenServer 6
$user = 'root';
$pass = '';
$dbname = 'php_lr3'; // Имя вашей БД

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>