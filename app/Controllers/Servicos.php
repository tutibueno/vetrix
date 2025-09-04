<?php

namespace App\Controllers;

use App\Models\ServicoModel;

class Servicos extends BaseController
{
    protected $servicoModel;

    public function __construct()
    {
        $this->servicoModel = new ServicoModel();
    }

    public function index()
    {
        $data['servicos'] = $this->servicoModel->findAll();
        return view('servicos/index', $data);
    }

    public function create()
    {
        return view('servicos/form', ['servico' => null]);
    }

    public function store()
    {
        $this->servicoModel->save([
            'id'             => $this->request->getPost('id'),
            'nome_servico'   => $this->request->getPost('nome_servico'),
            'duracao_padrao' => $this->request->getPost('duracao_padrao'),
            'preco'          => $this->request->getPost('preco'),
        ]);

        return redirect()->to('/servicos')->with('success', 'Serviço salvo com sucesso!');
    }

    public function edit($id)
    {
        $servico = $this->servicoModel->find($id);
        if (!$servico) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Serviço não encontrado");
        }

        return view('servicos/form', ['servico' => $servico]);
    }

    public function delete($id)
    {
        $this->servicoModel->delete($id);
        return redirect()->to('/servicos')->with('success', 'Serviço removido com sucesso!');
    }
}
