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
        
        .success-badge {
            background: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            margin-left: 10px;
        }
        
        .api-status {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        
        .api-icon {
            font-size: 24px;
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

        <!-- ДАННЫЕ ИЗ API ПО ЗАДАНИЮ - ТОЛЬКО СТАТУС -->
        <?php if(isset($_SESSION['api_data'])): ?>
            <div class="api-data">
                <div class="api-status">
                    <span class="api-icon">✅</span>
                    <h3 style="margin: 0;">Данные из API успешно загружены</h3>
                    <span class="success-badge">REST Countries API</span>
                </div>
                <p><strong>Получено записей:</strong> <?php echo is_array($_SESSION['api_data']) ? count($_SESSION['api_data']) : '0'; ?></p>
                <p><em>Данные получены в соответствии с требованиями задания</em></p>
                <?php unset($_SESSION['api_data']); ?>
            </div>
        <?php endif; ?>

        <!-- Информация о выбранной стране -->
        <?php if(isset($_SESSION['country_info'])): ?>
            <div class="api-data">
                <h3>🇺🇳 Информация о выбранной стране:</h3>
                <?php if(isset($_SESSION['country_info']['error'])): ?>
                    <p style="color: red;"><?php echo htmlspecialchars($_SESSION['country_info']['error']); ?></p>
                <?php else: ?>
                    <div class="country-card">
                        <h4><?php echo htmlspecialchars($_SESSION['country_info']['name'] ?? 'Страна'); ?></h4>
                        <p><strong>Официальное название:</strong> <?php echo htmlspecialchars($_SESSION['country_info']['official_name'] ?? 'Неизвестно'); ?></p>
                        <p><strong>Столица:</strong> <?php echo htmlspecialchars($_SESSION['country_info']['capital'] ?? 'Не указана'); ?></p>
                        <p><strong>Регион:</strong> <?php echo htmlspecialchars($_SESSION['country_info']['region'] ?? 'Неизвестно'); ?></p>
                        <p><strong>Население:</strong> <?php echo htmlspecialchars($_SESSION['country_info']['population'] ?? '0'); ?></p>
                        <p><strong>Площадь:</strong> <?php echo htmlspecialchars($_SESSION['country_info']['area'] ?? '0'); ?></p>
                        <p><strong>Языки:</strong> <?php echo htmlspecialchars($_SESSION['country_info']['languages'] ?? 'Не указаны'); ?></p>
                        <?php if(isset($_SESSION['country_info']['flag'])): ?>
                            <img src="<?php echo htmlspecialchars($_SESSION['country_info']['flag']); ?>" alt="Флаг" style="max-width: 100px; margin-top: 10px; border: 1px solid #ddd;">
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php unset($_SESSION['country_info']); ?>
            </div>
        <?php endif; ?>

        <!-- Данные из формы -->
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