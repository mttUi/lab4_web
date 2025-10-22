<?php
session_start();
require_once 'ApiClient.php';
require_once 'UserInfo.php';

// Получаем данные формы
$name = $_POST['name'] ?? '';
$country = $_POST['country'] ?? '';

// Сохраняем в сессию
$_SESSION['username'] = $name;
$_SESSION['country'] = $country;

// Получаем данные из API (строго по заданию)
$api = new ApiClient();
$url = 'https://restcountries.com/v3.1/all'; // API из задания
$_SESSION['api_data'] = $api->request($url);

// Устанавливаем куки (строго по заданию)
setcookie("last_submission", date('Y-m-d H:i:s'), time() + 3600, "/");

// Перенаправляем на главную страницу
header("Location: index.php");
exit();