<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClientModel;

class Client extends BaseController
{
    protected $clientModel;

    public function __construct()
    {
        $this->clientModel = new ClientModel();
    }

    public function index()
    {
        $search = $this->request->getGet('q');
        $model = new ClientModel();

        $query = $model;
        if ($search) {
            $query = $query->like('nome', $search)->orLike('cpf_cnpj', $search);
        }

        $query = $query->orderBy('created_at', 'DESC');

        $data['clients'] = $query->paginate(10);
        $data['pager'] = $query->pager;
        $data['search'] = $search;

        return view('clients/index', $data);
    }


    public function create()
    {
        return view('clients/create');
    }

    public function store()
    {
        $data = $this->request->getPost();

        if (!$this->clientModel->save($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->clientModel->errors());
        }

        return redirect()->to('/client')->with('success', 'Cliente cadastrado com sucesso.');
    }

    public function edit($id)
    {
        $data['client'] = $this->clientModel->find($id);
        return view('clients/edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $data['id'] = $id;

        if (!$this->clientModel->save($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->clientModel->errors());
        }

        return redirect()->to('/client')->with('success', 'Cliente atualizado com sucesso.');
    }

    public function delete($id)
    {
        //Desabilitado por padrão

        //$this->clientModel->delete($id);
        return redirect()->to('/client')->with('success', 'Cliente excluído com sucesso.');
    }

    public function buscar()
    {
        $term = $this->request->getGet('term');

        $clientes = $this->clientModel
            ->like('nome', $term)
            ->findAll(10); // limite para não sobrecarregar

        $result = [];
        foreach ($clientes as $c) {
            $result[] = [
                'id' => $c['id'],
                'nome' => $c['nome'],
                'cpf_cnpj' => $c['cpf_cnpj'],
                'telefone' => $c['telefone']
            ];
        }

        return $this->response->setJSON($result);
    }
}
