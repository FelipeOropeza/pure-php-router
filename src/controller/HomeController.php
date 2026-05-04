<?php

namespace App\Controller;

use App\Core\Controller;
use App\Model\User;

class HomeController extends Controller
{
    public function home()
    {
        $userModel = new User();
        $userModel->teste();
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