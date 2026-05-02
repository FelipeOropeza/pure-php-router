<?php

namespace App\Core;

class Request
{
    public static function post(): array
    {
        return $_POST;
    }
}