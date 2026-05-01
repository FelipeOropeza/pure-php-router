<?php

use App\Core\Route;
require_once __DIR__ . '/../vendor/autoload.php';

Route::add('GET', '/home', 'HomeController@home');
Route::add('GET', '/', 'HomeController@home');

Route::run();
