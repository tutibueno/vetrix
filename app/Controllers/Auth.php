<?php

// app/Controllers/Auth.php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login', ['title' => 'Login']);
    }

    public function doLogin()
    {
        $session = session();
        $model = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $user = $model->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $session->set([
                'user_id' => $user['id'],
                'user_name' => $user['name'],
                'logged_in' => true
            ]);
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
