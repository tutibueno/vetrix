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

        $rules = [
            'name' => [
                'rules'  => 'required|min_length[3]|max_length[50]|is_unique[users.name]',
                'errors' => [
                    'required'   => 'O campo nome é obrigatório.',
                    'min_length' => 'O nome deve ter no mínimo 3 caracteres.',
                    'max_length' => 'O nome pode ter no máximo 150 caracteres.'
                ]
            ],
            'username' => [
                'rules'  => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
                'errors' => [
                    'required'   => 'O campo usuário é obrigatório.',
                    'min_length' => 'O usuário deve ter no mínimo 3 caracteres.',
                    'max_length' => 'O usuário pode ter no máximo 50 caracteres.',
                    'is_unique'  => 'Este nome de usuário já está em uso.'
                ]
            ],
            'email' => [
                'rules'  => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required'    => 'O campo e-mail é obrigatório.',
                    'valid_email' => 'Informe um e-mail válido.',
                    'is_unique'   => 'Este e-mail já está em uso.'
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[6]',
                'errors' => [
                    'required'   => 'A senha é obrigatória.',
                    'min_length' => 'A senha deve ter no mínimo 6 caracteres.'
                ]
            ]
        ];

        if ($this->request->getPost()) {
            if (! $this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $this->userModel->insert([
                'username' => $this->request->getPost('username'),
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'perfil' => $this->request->getPost('perfil'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
            ]);
        }

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
        $rules = [
            'name' => [
                'rules'  => "required|min_length[3]|max_length[150]",
                'errors' => [
                    'required'   => 'O campo nome é obrigatório.',
                    'min_length' => 'O nome deve ter no mínimo 3 caracteres.',
                    'max_length' => 'O nome pode ter no máximo 150 caracteres.'
                ]
            ],
            'username' => [
                'rules'  => "required|min_length[3]|max_length[50]|is_unique[users.username,id,{$id}]",
                'errors' => [
                    'required'   => 'O campo usuário é obrigatório.',
                    'min_length' => 'O usuário deve ter no mínimo 3 caracteres.',
                    'max_length' => 'O usuário pode ter no máximo 50 caracteres.',
                    'is_unique'  => 'Este nome de usuário já está em uso.'
                ]
            ],
            'email' => [
                'rules'  => "required|valid_email|is_unique[users.email,id,{$id}]",
                'errors' => [
                    'required'    => 'O campo e-mail é obrigatório.',
                    'valid_email' => 'Informe um e-mail válido.',
                    'is_unique'   => 'Este e-mail já está em uso.'
                ]
            ]
        ];

        if ($this->request->getPost()) {
            if (! $this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $this->userModel->update($id, [
                'username' => $this->request->getPost('username'),
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'perfil' => $this->request->getPost('perfil')
            ]);
        }

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
