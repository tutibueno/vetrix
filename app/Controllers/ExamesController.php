<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SolicitacaoExameModel;
use App\Models\PetModel;
use App\Models\VeterinarioModel;

class ExamesController extends BaseController
{
    protected $exameModel;
    protected $petModel;
    protected $veterinarioModel;

    public function __construct()
    {
        $this->exameModel = new SolicitacaoExameModel();
        $this->petModel   = new PetModel();
    }

    // Lista todos os exames de um pet
    public function index($pet_id)
    {
        $pet = $this->petModel->find($pet_id);
        $exames = $this->exameModel->where('pet_id', $pet_id)->findAll();

        return view('exames/index', [
            'pet' => $pet,
            'exames' => $exames
        ]);
    }

    // Cria uma nova solicitação para o pet
    public function create($pet_id)
    {
        $veterinarios = $this->veterinarioModel->findAll();

        $pet = $this->petModel->find($pet_id);
        return view('exames/_form', [
            'action' => site_url('exames/store'),
            'pet_id' => $pet['id'],
            'nome_pet' => $pet['nome'],
            'veterinarios' => $veterinarios
        ]);
    }

    public function store($pet_id)
    {
        $this->exameModel->save([
            'pet_id' => $pet_id,
            'veterinario_id' => session()->get('veterinario_id'), // pegar do login
            'data_solicitacao' => $this->request->getPost('data_solicitacao'),
            'observacoes' => $this->request->getPost('observacoes'),
        ]);

        return redirect()->to("/exames/$pet_id")->with('success', 'Solicitação de exame criada com sucesso!');
    }

    // Edita a solicitação (já sabemos o pet pelo exame)
    public function edit($id)
    {
        $exame = $this->exameModel->find($id);
        $pet = $this->petModel->find($exame['pet_id']);

        return view('exames/edit', [
            'pet' => $pet,
            'exame' => $exame
        ]);
    }

    public function update($id)
    {
        $exame = $this->exameModel->find($id);

        $this->exameModel->update($id, [
            'data_solicitacao' => $this->request->getPost('data_solicitacao'),
            'observacoes' => $this->request->getPost('observacoes'),
        ]);

        return redirect()->to("/exames/{$exame['pet_id']}")->with('success', 'Solicitação de exame atualizada!');
    }

    public function delete($id)
    {
        $exame = $this->exameModel->find($id);
        $this->exameModel->delete($id);

        return redirect()->to("/exames/{$exame['pet_id']}")->with('success', 'Solicitação de exame excluída!');
    }
}
