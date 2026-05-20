<?php

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) return;
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

set_exception_handler(function (Throwable $e) {
    http_response_code(500);
    
    if ($_ENV['APP_ENV'] === 'development') {
        echo "<h1>Erro no sistema</h1>";
        echo "<pre>" . $e->getMessage() . "</pre>";
    } else {
        echo "Ops! Ocorreu um erro inesperado. Tente novamente mais tarde.";
    }
});