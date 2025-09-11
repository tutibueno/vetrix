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
            ->orderBy('data_hora_inicio', 'DESC')
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

        $inicio = strtotime($banho['data_hora_inicio']);
        $fim    = strtotime($banho['data_hora_fim']);
        $banho['duracao_minutos'] = round(($fim - $inicio) / 60);

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

        // Monta os dados básicos
        $data = [
            'pet_id'          => $post['pet_id'],
            'servico_id'      => $post['servico_id'],
            'data_hora_inicio' => $post['data_hora_inicio'],
            'status'          => $post['status'],
            'observacoes'     => $post['observacoes']
        ];

        // Calcula o fim com base na duração informada
        if (!empty($post['duracao_minutos'])) {
            $inicio = new \DateTime($post['data_hora_inicio']);
            $fim    = (clone $inicio)->modify("+{$post['duracao_minutos']} minutes");
            $data['data_hora_fim'] = $fim->format('Y-m-d H:i:s');
        } else {
            // se não veio duração, define fim igual ao início (opcional)
            $data['data_hora_fim'] = $data['data_hora_inicio'];
        }

        // Inserir ou atualizar
        if ($id) {
            $this->banhoModel->update($id, $data);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Agendamento atualizado com sucesso'
            ]);
        } else {

            //Gera o token
            $data['token'] = bin2hex(random_bytes(16));

            $this->banhoModel->insert($data);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Agendamento salvo com sucesso'
            ]);
        }
    }


    // Delete via AJAX
    public function delete($id)
    {
        $this->banhoModel->delete($id);
        return $this->response->setJSON(['success' => true, 'message' => 'Agendamento removido com sucesso']);
    }


    public function listarJson()
    {
        $banhos = $this->banhoModel
            ->select('banho_tosa.*, pets.nome as pet_nome, servicos.nome_servico as servico_nome')
            ->join('pets', 'pets.id = banho_tosa.pet_id')
            ->join('servicos', 'servicos.id = banho_tosa.servico_id')
            ->findAll();

        foreach ($banhos as &$b) {
            $inicio = strtotime($b['data_hora_inicio']);
            $fim    = strtotime($b['data_hora_fim']);
            $b['duracao_minutos'] = round(($fim - $inicio) / 60);
        }

        return $this->response->setJSON($banhos);
    }
}
