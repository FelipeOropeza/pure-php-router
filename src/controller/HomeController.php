<?php

namespace App\Controller;

use App\Core\Controller;

class HomeController extends Controller
{
    public function home()
    {
        $this->view('home', [
            'titulo' => 'Minha Página'
        ]);
    }

    public function create()
    {
        $this->view('create');
    }

    public function createPost(array $data)
    {
        $this->redirect('/create');
    }
}