<?php
require_once __DIR__ . '/vendor/autoload.php';
use GuzzleHttp\Client;

class ApiClient {
    private Client $client;

    public function __construct() {
        $this->client = new Client([
            'timeout' => 10,
            'verify' => false
        ]);
    }

    public function getAllCountries(): array {
        try {
            $response = $this->client->get('https://restcountries.com/v3.1/all');
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);
            
            $countries = [];
            foreach ($data as $country) {
                $countries[] = [
                    'name' => $country['name']['common'] ?? 'Неизвестно',
                    'capital' => $country['capital'][0] ?? 'Не указана',
                    'region' => $country['region'] ?? 'Неизвестно',
                    'population' => $country['population'] ?? 0
                ];
            }
            
            usort($countries, function($a, $b) {
                return strcmp($a['name'], $b['name']);
            });
            
            return $countries;
            
        } catch (\Exception $e) {
            return ['error' => 'Ошибка при получении данных: ' . $e->getMessage()];
        }
    }

    public function getCountryInfo(string $countryName): array {
        try {
            $response = $this->client->get('https://restcountries.com/v3.1/name/' . urlencode($countryName));
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);
            
            if (isset($data[0])) {
                $country = $data[0];
                return [
                    'name' => $country['name']['common'] ?? 'Неизвестно',
                    'official_name' => $country['name']['official'] ?? 'Неизвестно',
                    'capital' => $country['capital'][0] ?? 'Не указана',
                    'region' => $country['region'] ?? 'Неизвестно',
                    'population' => number_format($country['population'] ?? 0),
                    'area' => number_format($country['area'] ?? 0) . ' км²',
                    'languages' => implode(', ', $country['languages'] ?? []),
                    'flag' => $country['flags']['png'] ?? ''
                ];
            }
            
            return ['error' => 'Страна не найдена'];
            
        } catch (\Exception $e) {
            return ['error' => 'Ошибка при поиске страны: ' . $e->getMessage()];
        }
    }
}