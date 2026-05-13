<?php

namespace App\Core;

class Request
{
    /**
     * @param array|int $filters Pode ser um filtro único ou um array de filtros específicos
     */
    public static function post($filters = FILTER_SANITIZE_SPECIAL_CHARS): array
    {
        $data = filter_input_array(INPUT_POST, $filters);
        
        return $data ?? [];
    }
}