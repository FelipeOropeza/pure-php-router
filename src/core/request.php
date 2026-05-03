<?php

namespace App\Core;

class Request
{
    public static function post(): array
    {
        $data = [];

        foreach ($_POST as $key => $value) {
            $data[$key] = htmlspecialchars($value);
        }

        return $data;
    }
}