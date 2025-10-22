<?php
session_start();
require_once 'ApiClient.php';
require_once 'UserInfo.php';

// Получаем данные формы
$name = htmlspecialchars($_POST['name']);
$country = htmlspecialchars($_POST['country']);

// Сохраняем в сессию
$_SESSION['username'] = $name;
$_SESSION['country'] = $country;

// Получаем данные из API
$apiClient = new ApiClient();
$_SESSION['api_data'] = $apiClient->getCountryInfo($country);

// Сохраняем время отправки в куки
UserInfo::saveSubmissionTime();

// Сохраняем в файл
$dataLine = $name . ";" . $country . ";" . date('Y-m-d H:i:s') . "\n";
file_put_contents("data.txt", $dataLine, FILE_APPEND);

// Перенаправляем на главную страницу
header("Location: index.php");
exit();
?>