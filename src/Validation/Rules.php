<?php

namespace Ilasadkin\CryptoData\Validation;

class Rules
{
    /**
     * Валидация для интервала времени
     * @param string $param
     * @return bool
     */
    function validateInterval(string $param): bool
    {
        $allowed_values = array('m1', 'm5', 'm15', 'm30', 'h1', 'h2', 'h6', 'h12', 'd1');
        return in_array($param, $allowed_values);
    }
}