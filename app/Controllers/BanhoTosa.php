<?php

namespace App\Controllers;

use App\Models\BanhoTosaModel;
use App\Models\PetModel;
use App\Models\ServicoModel;

class BanhoTosa extends BaseController
{
    protected $banhoModel;
    protected $petModel;
    protected $servicoModel;

    public function __construct()
    {
        $this->banhoModel = new BanhoTosaModel();
        $this->petModel = new PetModel();
        $this->servicoModel = new ServicoModel();
    }

    public function index()
    {
        $model = new BanhoTosaModel();
        $data['banhos'] = $model
            ->select("banho_tosa.*, pets.nome AS pet_nome, servicos.nome_servico")
            ->join("servicos", "servicos.id = banho_tosa.servico_id", "left")
            ->join("pets", "pets.id = banho_tosa.pet_id", "left")
            ->orderBy('data_agendamento', 'DESC')
            ->findAll();

        $petModel = new PetModel();
        $data['pets'] = $petModel
            ->select("pets.id, pets.nome, clients.nome AS cliente_nome")
            ->join("clients", "clients.id = pets.cliente_id", "left")
            ->findAll();

        return view('banhotosa/index', $data);
    }

    // Abrir modal para criar
    public function create()
    {
        $data['pets'] = $this->petModel
            ->select("pets.id, pets.nome, clients.nome AS cliente_nome")
            ->join("clients", "clients.id = pets.cliente_id", "left")
            ->orderBy('pets.nome')
            ->findAll();

        $data['servicos'] = $this->servicoModel->orderBy('nome_servico')->findAll();

        return view('banhotosa/_form', $data);
    }

    // Abrir modal para editar
    public function edit($id)
    {
        $banho = $this->banhoModel->find($id);
        if (!$banho) {
            return $this->response->setStatusCode(404)->setBody('Agendamento não encontrado');
        }

        $data['banho'] = $banho;

        $data['pets'] = $this->petModel
            ->select("pets.id, pets.nome, clients.nome AS cliente_nome")
            ->join("clients", "clients.id = pets.cliente_id", "left")
            ->orderBy('pets.nome')
            ->findAll();

        $data['servicos'] = $this->servicoModel->orderBy('nome_servico')->findAll();

        return view('banhotosa/_form', $data);
    }

    // Store e update via AJAX
    public function store()
    {
        $post = $this->request->getPost();

        $id = $post['id'] ?? null;

        $data = [
            'pet_id' => $post['pet_id'],
            'servico_id' => $post['servico_id'],
            'data_agendamento' => $post['data_agendamento'],
            'duracao_minutos' => $post['duracao_minutos'],
            'status' => $post['status'],
            'observacoes' => $post['observacoes']
        ];

        if ($id) {
            $this->banhoModel->update($id, $data);
            return $this->response->setJSON(['success' => true, 'message' => 'Agendamento atualizado com sucesso']);
        } else {
            $this->banhoModel->insert($data);
            return $this->response->setJSON(['success' => true, 'message' => 'Agendamento criado com sucesso']);
        }
    }

    // Delete via AJAX
    public function delete($id)
    {
        $this->banhoModel->delete($id);
        return $this->response->setJSON(['success' => true, 'message' => 'Agendamento removido com sucesso']);
    }
}
