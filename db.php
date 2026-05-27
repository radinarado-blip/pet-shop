<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "petshop";

// Създаване на връзка
$conn = new mysqli($host, $user, $password, $database);

// Проверка за грешка
if ($conn->connect_error) {
    die("❌ Грешка при връзка с база данни: " . $conn->connect_error);
}

// Задаване на UTF-8 (за български текст)
$conn->set_charset("utf8");
?>