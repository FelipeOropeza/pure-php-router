<?php

namespace App\Controller;

use App\Core\Controller;

class HomeController extends Controller
{
    public function home()
    {
        $this->view('home');
    }
}