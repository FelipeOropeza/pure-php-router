<?php

namespace App\Controller;

use App\Core\Controller;
use App\Model\User;
use Exception;

class HomeController extends Controller
{
    public function home()
    {
        try {
            $userModel = new User();

            $sql = $userModel
                ->select()
                ->where("nome", "Felipe")
                ->where("id", 2)
                ->orderBy('nome')
                ->limit(1)
                ->get();

            // $userModel->update([
            //     'nome' => "Felipe1",
            //     'email' => "Teste@gmail.com",
            //     'senha' => "32332323"
            // ], 2);

            var_dump($sql);

            // $userModel->delete(1);
            die();

            $this->view('home', [
                'titulo' => 'Minha Página'
            ]);
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }

    public function create()
    {
        $this->view('create');
    }

    public function createPost(array $data)
    {
        // $userModel->insert([
        //     'nome' => 'Felipe',
        //     'email' => 'felipe2006.co@gmail.com',
        //     'senha' => '1234567'
        // ]);

        $this->redirect('/create');
    }
}
