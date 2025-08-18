<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SolicitacaoExameModel;
use App\Models\PetModel;
use App\Models\VeterinarioModel;
use App\Models\SolicitacaoExameMotivoModel;
use App\Models\SolicitacaoExameDetalheModel;

class ExamesController extends BaseController
{
    protected $petModel;
    protected $veterinarioModel;
    protected $solicitacaoModel;
    protected $exameModel;
    protected $motivoModel;

    public function __construct()
    {
        $this->petModel         = new PetModel();
        $this->veterinarioModel = new VeterinarioModel();
        $this->solicitacaoModel = new SolicitacaoExameModel();
        $this->exameModel       = new SolicitacaoExameDetalheModel();
        $this->motivoModel      = new SolicitacaoExameMotivoModel();
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
            'pet' => $pet,
            'nome_pet' => $pet['nome'],
            'veterinarios' => $veterinarios
        ]);
    }

    public function store($pet_id)
    {
        $data = $this->request->getPost();

        // 1) Cria a solicitação principal
        $solicitacaoId = $this->solicitacaoModel->insert([
            'pet_id'           => $pet_id,
            'veterinario_id'   => $data['veterinario_id'],
            'data_solicitacao' => $data['data_solicitacao'],
            'observacoes'      => $data['observacoes'] ?? null,
        ]);

        // 2) Salva exames vinculados
        if (!empty($data['exames'])) {
            foreach ($data['exames'] as $exame) {
                if (!empty($exame['nome_exame'])) {
                    $this->exameModel->insert([
                        'solicitacao_id' => $solicitacaoId,
                        'nome_exame'     => $exame['nome_exame'],
                        'observacoes'    => $exame['observacoes'] ?? null,
                    ]);
                }
            }
        }

        // 3) Salva motivos vinculados
        if (!empty($data['motivos'])) {
            foreach ($data['motivos'] as $motivo) {
                if (!empty($motivo['motivo'])) {
                    $this->motivoModel->insert([
                        'solicitacao_id' => $solicitacaoId,
                        'motivo'         => $motivo['motivo'],
                    ]);
                }
            }
        }

        return redirect()->to('/pet/ficha/' . $pet_id)
            ->with('success', 'Solicitação de exames cadastrada com sucesso!');

        return redirect()->to('/pet/ficha/' . $pet_id)
            ->with('success', 'Solicitação de exames cadastrada com sucesso!');

        return redirect()->to(site_url("/pet/ficha/$pet_id"))->with('success', 'Solicitação de exame criada com sucesso!');
    }

    // Edita a solicitação (já sabemos o pet pelo exame)
    public function edit($id)
    {
        $exame = $this->solicitacaoModel->find($id);

        if (!$exame) {
            return redirect()->back()->with('error', 'Solicitação não encontrada.');
        }

        $exame['itens'] = $this->exameModel->where('solicitacao_id', $id)->findAll();

        $pet = $this->petModel->find($exame['pet_id']);
        $veterinarios = $this->veterinarioModel->findAll();

        return view('exames/_form', [
            'pet' => $pet,
            'exame' => $exame,
            'veterinarios' => $veterinarios
        ]);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $solicitacao = $this->solicitacaoModel->find($id);

        if (!$solicitacao) {
            return redirect()->back()->with('error', 'Solicitação não encontrada.');
        }

        // 1) Atualiza dados da solicitação
        $this->solicitacaoModel->update($id, [
            'veterinario_id'   => $data['veterinario_id'],
            'data_solicitacao' => $data['data_solicitacao'],
            'observacoes'      => $data['observacoes'] ?? null,
        ]);

        // 2) Remove exames e recria
        $this->exameModel->where('solicitacao_id', $id)->delete();
        if (!empty($data['exames'])) {
            foreach ($data['exames'] as $exame) {
                if (!empty($exame['nome_exame'])) {
                    $this->exameModel->insert([
                        'solicitacao_id' => $id,
                        'nome_exame'     => $exame['nome_exame'],
                        'observacoes'    => $exame['observacoes'] ?? null,
                    ]);
                }
            }
        }

        // 3) Remove motivos e recria
        $this->motivoModel->where('solicitacao_id', $id)->delete();
        if (!empty($data['motivos'])) {
            foreach ($data['motivos'] as $motivo) {
                if (!empty($motivo['motivo'])) {
                    $this->motivoModel->insert([
                        'solicitacao_id' => $id,
                        'motivo'         => $motivo['motivo'],
                    ]);
                }
            }
        }

        return redirect()->to('/pets/ficha/' . $solicitacao['pet_id'])
            ->with('success', 'Solicitação de exames atualizada com sucesso!');

        return redirect()->to("/pet/ficha/{$exame['pet_id']}")->with('success', 'Solicitação de exame atualizada!');
    }

    public function delete($id)
    {
        $solicitacao = $this->solicitacaoModel->find($id);
        
        if (!$solicitacao) {
            return redirect()->back()->with('error', 'Solicitação não encontrada.');
        }

        //$this->exameModel->where('solicitacao_id', $id)->delete();
        //$this->motivoModel->where('solicitacao_id', $id)->delete();
        $this->solicitacaoModel->delete($id);

        return redirect()->to('/pets/ficha/' . $solicitacao['pet_id'])
            ->with('success', 'Solicitação de exames removida com sucesso!');
    }
}
