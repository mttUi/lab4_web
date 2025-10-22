<?php
session_start();
require_once 'UserInfo.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лабораторная работа №4 - API стран</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 40px;
            max-width: 1000px;
            margin: 0 auto;
        }
        
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
        }
        
        .nav {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .nav a {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 10px 20px;
            margin: 0 10px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
        
        .info-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #48cae4;
        }
        
        .api-data {
            background: #e7f3ff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .country-card {
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            border-left: 4px solid #28a745;
        }
        
        .debug {
            background: #fff3cd;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🌍 Лабораторная работа №4 - API стран</h1>
        
        <div class="nav">
            <a href="form.html">📝 Форма регистрации</a>
            <a href="countries.php">📊 Все страны</a>
        </div>

        <!-- Информация о пользователе -->
        <div class="info-section">
            <h3>👤 Информация о пользователе:</h3>
            <?php
            $clientInfo = UserInfo::getClientInfo();
            foreach ($clientInfo as $key => $value) {
                echo '<p><strong>' . htmlspecialchars($key) . ':</strong> ' . htmlspecialchars($value) . '</p>';
            }
            ?>
            <p><strong>Последняя отправка формы:</strong> <?php echo htmlspecialchars(UserInfo::getLastSubmission()); ?></p>
        </div>

        <!-- Данные из API -->
        <?php if(isset($_SESSION['api_data'])): ?>
            <div class="api-data">
                <h3>🇺🇳 Данные из API стран:</h3>
                <?php if(isset($_SESSION['api_data']['error'])): ?>
                    <p style="color: red;"><?php echo htmlspecialchars($_SESSION['api_data']['error']); ?></p>
                <?php else: ?>
                    <div class="country-card">
                        <h4><?php echo htmlspecialchars($_SESSION['api_data']['name'] ?? 'Страна'); ?></h4>
                        <p><strong>Официальное название:</strong> <?php echo htmlspecialchars($_SESSION['api_data']['official_name'] ?? 'Неизвестно'); ?></p>
                        <p><strong>Столица:</strong> <?php echo htmlspecialchars($_SESSION['api_data']['capital'] ?? 'Не указана'); ?></p>
                        <p><strong>Регион:</strong> <?php echo htmlspecialchars($_SESSION['api_data']['region'] ?? 'Неизвестно'); ?></p>
                        <p><strong>Население:</strong> <?php echo htmlspecialchars($_SESSION['api_data']['population'] ?? '0'); ?></p>
                        <p><strong>Площадь:</strong> <?php echo htmlspecialchars($_SESSION['api_data']['area'] ?? '0'); ?></p>
                        <p><strong>Языки:</strong> <?php echo htmlspecialchars($_SESSION['api_data']['languages'] ?? 'Не указаны'); ?></p>
                        <?php if(isset($_SESSION['api_data']['flag'])): ?>
                            <img src="<?php echo htmlspecialchars($_SESSION['api_data']['flag']); ?>" alt="Флаг" style="max-width: 100px; margin-top: 10px;">
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php unset($_SESSION['api_data']); ?>
            </div>
        <?php endif; ?>

        <!-- Данные из сессии -->
        <?php if(isset($_SESSION['username'])): ?>
            <div class="info-section" style="border-left-color: #28a745;">
                <h3>✅ Данные из формы:</h3>
                <p><strong>Имя:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                <p><strong>Выбранная страна:</strong> <?php echo htmlspecialchars($_SESSION['country'] ?? 'Не выбрана'); ?></p>
                <?php
                unset($_SESSION['username']);
                unset($_SESSION['country']);
                ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>