<?php
require_once 'ApiClient.php';
require_once 'UserInfo.php';

$apiClient = new ApiClient();
$countriesData = $apiClient->getAllCountries();

// ОБРАБОТКА ОШИБОК
if (isset($countriesData['error'])) {
    $error = $countriesData['error'];
    $countries = [];
} else {
    $countries = $countriesData;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Все страны мира</title>
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
            max-width: 1200px;
            margin: 0 auto;
        }
        
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
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
        
        .countries-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .country-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #28a745;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .country-flag {
            width: 60px;
            height: 40px;
            object-fit: cover;
            border-radius: 3px;
        }
        
        .country-info {
            flex: 1;
        }
        
        .country-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        
        .country-details {
            font-size: 14px;
            color: #666;
        }
        
        .stats {
            background: #e7f3ff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .error {
            background: #ffe6e6;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border-left: 4px solid #ff4444;
        }
        
        .success {
            background: #e6ffe6;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border-left: 4px solid #28a745;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🌍 Все страны мира</h1>
        
        <div class="nav">
            <a href="index.php">← На главную</a>
            <a href="form.html">📝 Форма регистрации</a>
        </div>

        <div class="stats">
            <h3>📊 Получено стран из API: <?php echo count($countries); ?></h3>
            <p>Данные предоставлены REST Countries API</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="error">
                <h3>❌ Ошибка при загрузке данных:</h3>
                <p><?php echo htmlspecialchars($error); ?></p>
                <p><small>Используются тестовые данные</small></p>
            </div>
        <?php elseif (empty($countries)): ?>
            <div class="error">
                <p>Нет данных для отображения</p>
            </div>
        <?php else: ?>
            <div class="success">
                <p>✅ Данные успешно загружены из API</p>
            </div>
        <?php endif; ?>

        <div class="countries-grid">
            <?php foreach($countries as $country): ?>
                <?php if (is_array($country) && isset($country['name'])): ?>
                    <div class="country-card">
                        <?php if (!empty($country['flag'])): ?>
                            <img src="<?php echo htmlspecialchars($country['flag']); ?>" alt="Флаг <?php echo htmlspecialchars($country['name']); ?>" class="country-flag">
                        <?php endif; ?>
                        <div class="country-info">
                            <div class="country-name"><?php echo htmlspecialchars($country['name']); ?></div>
                            <div class="country-details">
                                <strong>Столица:</strong> <?php echo htmlspecialchars($country['capital']); ?><br>
                                <strong>Регион:</strong> <?php echo htmlspecialchars($country['region']); ?><br>
                                <strong>Население:</strong> <?php echo number_format($country['population']); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>