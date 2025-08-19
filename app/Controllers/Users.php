<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Usuários',
            'users' => $this->userModel->findAll()
        ];
        return view('users/index', $data);
    }

    public function create()
    {
        helper('form');
        $perfis = $this->userModel->getPerfis();
        return view('users/create', [
            'title' => 'Novo Usuário',
            'perfis'  => $perfis
        ]);
    }

    public function store()
    {
        $this->userModel->save([
            'username' => $this->request->getPost('username'),
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'perfil' => $this->request->getPost('perfil'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ]);
        return redirect()->to('/users');
    }

    public function edit($id)
    {
        helper('form');
        $user = $this->userModel->find($id);
        $perfis = $this->userModel->getPerfis();
        return view('users/edit', [
            'user' => $user, 
            'title' => 'Editar Usuário',
            'perfis' => $perfis
        ]);
    }

    public function update($id)
    {
        $this->userModel->update($id, [
            'username' => $this->request->getPost('username'),
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'perfil' => $this->request->getPost('perfil'),
        ]);
        return redirect()->to('/users');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        return redirect()->to('/users');
    }
}
