<?php
// ВКЛЮЧАЕМ БУФЕРИЗАЦИЮ вывода
ob_start();

session_start();
require_once 'ApiClient.php';
require_once 'UserInfo.php';

// Получаем данные формы
$name = htmlspecialchars($_POST['name'] ?? '');
$country = htmlspecialchars($_POST['country'] ?? '');

// Сохраняем в сессию
$_SESSION['username'] = $name;
$_SESSION['country'] = $country;

// ПО ЗАДАНИЮ: получаем данные из API через метод request()
$api = new ApiClient();
$url = 'https://restcountries.com/v3.1/all';
$_SESSION['api_data'] = $api->request($url);

// ПО ЗАДАНИЮ: устанавливаем куки
setcookie("last_submission", date('Y-m-d H:i:s'), time() + 3600, "/");

// Дополнительно: сохраняем информацию о выбранной стране
$_SESSION['country_info'] = $api->getCountryInfo($country);

// Сохраняем в файл
$dataLine = $name . ";" . $country . ";" . date('Y-m-d H:i:s') . "\n";
file_put_contents("data.txt", $dataLine, FILE_APPEND);

// ОЧИЩАЕМ буфер и перенаправляем
ob_end_clean();
header("Location: index.php");
exit();
?>