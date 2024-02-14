<?php

namespace Ilasadkin\CryptoData;

use Ilasadkin\CryptoData\Dictionary\Messages;
use Ilasadkin\CryptoData\Validation\Rules;

class GetData
{
    protected Messages $messages;
    protected Rules $rules;

    function __construct()
    {
        $this->messages = new Messages();
        $this->rules = new Rules();
    }

    /**
     * Основная функция для вызова
     * @param string $url endpoint url
     * @param string $method method name (GET or POST)
     * @return array answer
     */
    protected function fetchData(string $url, string $method = 'GET'): array
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        switch ($method) {
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, true);
                break;
            case 'GET':
                break;
            default:
                return $this->messages->response('NO_TYPE');
        }

        $response = curl_exec($curl);
        curl_close($curl);
        if($response === false) {
            return $this->messages->response('NO_RESPONSE', $url);
        }

        $data = json_decode($response, true);
        if($data === null) {
            return $this->messages->response('RESPONSE_NULL', $url);
        }
        return $data;
    }

    /**
     * Получение информации по всем криптовалютам
     * @return array
     */
    public function getAllAssets(): array
    {
        return $this->fetchData("https://api.coincap.io/v2/assets");
    }

    /**
     * Получение информации по конкретной криптовалюте
     * @param string $name принимается id полученный из функции getAllAssets()
     * @return array
     */
    public function getIdAsset(string $name): array
    {
        return $this->fetchData("https://api.coincap.io/v2/assets/" . $name);
    }

    /**
     * Получение данных по цене в указанном интервале
     * @param string $name принимается id полученный из функции getAllAssets()
     * @param string $interval принмиается один из параметров m1, m5, m15, m30, h1, h2, h6, h12, d1. По умолчанию d1.
     * @return array
     */
    public function getIdHistory(string $name, string $interval = 'd1'): array
    {
        if (!$this->rules->validateInterval($interval)) {
            return $this->messages->response('INTERVAL_TYPE');
        }
        return $this->fetchData("https://api.coincap.io/v2/assets/" . $name . "/history?interval=" . $interval);
    }

    /**
     * Получение информации по конкретной криптовалюте со всем маркетов
     * @param string $name принимается id полученный из функции getAllAssets()
     * @return array
     */
    public function getIdMarkets(string $name): array
    {
        return $this->fetchData("https://api.coincap.io/v2/assets/" . $name . "/markets");
    }
}