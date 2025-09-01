<?php

// app/Controllers/Auth.php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        return view('auth/login', ['title' => 'Login']);
    }

    public function doLogin()
    {
        $model = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $user = $model->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {

            //Criar sessão com dados do usuário
            $sessionData = [
                'user' => [
                    'id'       => $user['id'],
                    'name'     => $user['name'],
                    'email'    => $user['email'],
                    'perfil'   => $user['perfil'],
                ],
                'user_id' => $user['id'],
                'user_name' => $user['name'],
                'perfil' => $user['perfil'],
                'logged_in' => true,
                'isLoggedIn' => true
            ];

            session()->set($sessionData);

            setcookie("remember_username", $this->request->getPost('username'), time() + 60 * 60 * 24 * 180, "/"); // 180 dias

            return redirect()->to('/');
        }

        return redirect()->back()->with('error', 'Usuário ou senha inválidos');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
