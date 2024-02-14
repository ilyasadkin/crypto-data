<?php

namespace Ilasadkin\CryptoData\Dictionary;

class Messages
{
    /**
     * Словарь ошибок
     * @param string $type
     * @param string|null $param
     * @return array
     */
    public function response(string $type, string|null $param = null): array
    {
        return match ($type) {
            'NO_TYPE' => ['error' => true, 'text' => "Не удалось опередлить HTTP метод."],
            'RESPONSE_NULL' => ['error' => true, 'text' => "Пришел пустой ответ, проверьте правильность передаваемых вами данных."],
            'NO_RESPONSE' => ['error' => true, 'text' => "Не удалось получить ответ от url: $param."],
            'INTERVAL_TYPE' => ['error' => true, 'text' => "Параметр интервал некорректный, првоерьте документацию."],
            default => ['error' => true, 'text' => "Неопознанная ошибка."],
        };
    }

}