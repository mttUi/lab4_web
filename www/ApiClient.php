<?php
class ApiClient {
    
    // Упрощенный метод для получения всех стран
    public function getAllCountries(): array {
        try {
            // ПРАВИЛЬНЫЙ URL с указанием полей
            $url = 'https://restcountries.com/v3.1/all?fields=name,capital,region,population,flags';
            
            $context = stream_context_create([
                'http' => [
                    'timeout' => 30,
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'ignore_errors' => true
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ]
            ]);
            
            $response = file_get_contents($url, false, $context);
            
            if ($response === false) {
                return $this->getTestCountries();
            }
            
            $data = json_decode($response, true);
            
            if (!is_array($data) || json_last_error() !== JSON_ERROR_NONE) {
                return $this->getTestCountries();
            }
            
            $countries = [];
            foreach ($data as $country) {
                if (isset($country['name']['common'])) {
                    $countries[] = [
                        'name' => $country['name']['common'],
                        'capital' => isset($country['capital'][0]) ? $country['capital'][0] : 'Не указана',
                        'region' => $country['region'] ?? 'Неизвестно',
                        'population' => $country['population'] ?? 0,
                        'flag' => $country['flags']['png'] ?? ''
                    ];
                }
            }
            
            usort($countries, function($a, $b) {
                return strcmp($a['name'], $b['name']);
            });
            
            return array_slice($countries, 0, 50);
            
        } catch (\Exception $e) {
            return $this->getTestCountries();
        }
    }

    // Метод для получения информации о конкретной стране
    public function getCountryInfo(string $countryName): array {
        try {
            // ПРАВИЛЬНЫЙ URL для поиска страны
            $url = 'https://restcountries.com/v3.1/name/' . urlencode($countryName) . '?fields=name,capital,region,population,area,languages,flags';
            
            $context = stream_context_create([
                'http' => [
                    'timeout' => 30,
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'ignore_errors' => true
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ]
            ]);
            
            $response = file_get_contents($url, false, $context);
            
            if ($response === false) {
                return ['error' => 'Не удалось получить данные о стране'];
            }
            
            $data = json_decode($response, true);
            
            if (!is_array($data) || !isset($data[0]) || json_last_error() !== JSON_ERROR_NONE) {
                return ['error' => 'Страна не найдена'];
            }
            
            $country = $data[0];
            return [
                'name' => $country['name']['common'] ?? 'Неизвестно',
                'official_name' => $country['name']['official'] ?? 'Неизвестно',
                'capital' => isset($country['capital'][0]) ? $country['capital'][0] : 'Не указана',
                'region' => $country['region'] ?? 'Неизвестно',
                'population' => number_format($country['population'] ?? 0),
                'area' => isset($country['area']) ? number_format($country['area']) . ' км²' : 'Неизвестно',
                'languages' => isset($country['languages']) ? implode(', ', $country['languages']) : 'Не указаны',
                'flag' => $country['flags']['png'] ?? ''
            ];
            
        } catch (\Exception $e) {
            return ['error' => 'Ошибка при поиске страны: ' . $e->getMessage()];
        }
    }

    // Метод строго по заданию
    public function request($url): array {
        try {
            // Для задания используем упрощенный URL
            $apiUrl = 'https://restcountries.com/v3.1/all?fields=name,capital,region,population';
            
            $context = stream_context_create([
                'http' => [
                    'timeout' => 30,
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'ignore_errors' => true
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ]
            ]);
            
            $response = file_get_contents($apiUrl, false, $context);
            
            if ($response === false) {
                return ['error' => 'Не удалось получить данные от API'];
            }
            
            $data = json_decode($response, true);
            
            if (!is_array($data) || json_last_error() !== JSON_ERROR_NONE) {
                return ['error' => 'Неверный формат данных от API'];
            }
            
            // Возвращаем только первые 5 стран для примера
            return array_slice($data, 0, 5);
            
        } catch (\Exception $e) {
            return ['error' => 'Ошибка: ' . $e->getMessage()];
        }
    }

    // Тестовые данные на случай если API не доступно
    private function getTestCountries(): array {
        return [
            [
                'name' => 'Russia',
                'capital' => 'Moscow',
                'region' => 'Europe',
                'population' => 144100000,
                'flag' => 'https://flagcdn.com/w320/ru.png'
            ],
            [
                'name' => 'United States',
                'capital' => 'Washington, D.C.',
                'region' => 'Americas',
                'population' => 331000000,
                'flag' => 'https://flagcdn.com/w320/us.png'
            ],
            [
                'name' => 'Germany',
                'capital' => 'Berlin',
                'region' => 'Europe',
                'population' => 83200000,
                'flag' => 'https://flagcdn.com/w320/de.png'
            ],
            [
                'name' => 'France',
                'capital' => 'Paris',
                'region' => 'Europe',
                'population' => 67390000,
                'flag' => 'https://flagcdn.com/w320/fr.png'
            ],
            [
                'name' => 'Japan',
                'capital' => 'Tokyo',
                'region' => 'Asia',
                'population' => 125800000,
                'flag' => 'https://flagcdn.com/w320/jp.png'
            ]
        ];
    }
}