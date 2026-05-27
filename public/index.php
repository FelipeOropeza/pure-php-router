<?php

use App\Core\Route;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Config/bootstrap.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

Route::add('GET', '/', 'HomeController@home');
Route::add('GET', '/user/{id}', 'HomeController@parametro');
Route::add('GET', '/create', 'HomeController@create');
Route::add('POST', '/createPost', 'HomeController@createPost');

Route::run();
