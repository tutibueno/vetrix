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

        $data = $this->request->getPost();

        // Verifica se já existe um usuário com esse username
        if ($this->userModel->where('username', $data['username'])->first()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Já existe um usuário com esse mesmo username.');
        }

        // Validação adicional (opcional)
        if (!$this->validate([
            'username' => 'required|min_length[3]',
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ])) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }


        // Validação adicional (opcional)
        if (!$this->validate([
            'name'     => 'required|min_length[3]',
            'username' => 'required|min_length[3]',
            'email'    => 'required|valid_email'
        ])) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->userModel->save([
            'username' => $this->request->getPost('username'),
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'perfil' => $this->request->getPost('perfil'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/users')->with('success', 'Usuário criado com sucesso!');
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
        // Dados do formulário
        $data = $this->request->getPost();

        // Verifica se o username já existe para outro usuário
        $existingUser = $this->userModel->where('username', $data['username'])
            ->where('id !=', $id)
            ->first();

        if ($existingUser) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Já existe um usuário com esse mesmo username.');
        }

        // Validação adicional (opcional)
        if (!$this->validate([
            'name'     => 'required|min_length[3]',
            'username' => 'required|min_length[3]',
            'email'    => 'required|valid_email'
        ])) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }


        $this->userModel->update($id, [
            'username' => $this->request->getPost('username'),
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'perfil' => $this->request->getPost('perfil'),
        ]);

        return redirect()->to('/users')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function delete($id)
    {
        //Recomendável não excluir um usuário por motivos de cascateamento de dados
        //$this->userModel->delete($id);
        return redirect()->back()
            ->withInput()
            ->with('error', 'Usuário não pode ser excluído no momento.');
    }
}
