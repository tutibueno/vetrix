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
        return view('users/create', ['title' => 'Novo Usuário']);
    }

    public function store()
    {
        $this->userModel->save([
            'username' => $this->request->getPost('username'),
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ]);
        return redirect()->to('/users');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        return view('users/edit', ['user' => $user, 'title' => 'Editar Usuário']);
    }

    public function update($id)
    {
        $this->userModel->update($id, [
            'username' => $this->request->getPost('username'),
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ]);
        return redirect()->to('/users');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        return redirect()->to('/users');
    }
}
