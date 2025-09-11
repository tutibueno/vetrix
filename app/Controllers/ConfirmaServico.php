<?php

namespace App\Controllers;

use App\Models\BanhoTosaModel;
use App\Models\ClientModel;
use App\Models\PetModel;
use App\Models\ServicoModel;

class ConfirmaServico extends PublicBaseController
{
    protected $banhoModel;
    protected $petModel;
    protected $clientModel;
    protected $servicoModel;
    protected $clinicaModel;

    public function __construct()
    {
        $this->banhoModel = new BanhoTosaModel();
        $this->petModel = new PetModel();
        $this->clientModel = new ClientModel();
        $this->servicoModel = new ServicoModel();
    }

    // Página inicial
    public function index($token)
    {
        $agendamento = $this->banhoModel->where('token', $token)->first();

        if (!$agendamento) {
            return $this->render('confirma/erro_token');
        }

        $pet = $this->petModel->find($agendamento['pet_id']);
        $cliente = $this->clientModel->find($pet['cliente_id']);
        $servico = $this->servicoModel->find($agendamento['servico_id']);

        $agendamento['tutor_nome'] = $cliente['nome'];
        $agendamento['pet_nome'] = $pet['nome'];
        $agendamento['nome_servico'] = $servico['nome_servico'];

        return $this->render('confirma/servico_index', ['agendamento' => $agendamento]);
    }

    // Confirmar
    public function confirmar($token)
    {
        $agendamento = $this->banhoModel->where('token', $token)->first();

        if (!$agendamento) {
            return $this->render('confirma/erro_token');
        }

        $this->banhoModel->update($agendamento['id'], ['status' => 'confirmado']);

        return $this->render('confirma/sucesso', [
            'mensagem' => 'Banho & Tosa confirmado com sucesso!'
        ]);
    }

    // Cancelar
    public function cancelar($token)
    {
        $agendamento = $this->banhoModel->where('token', $token)->first();

        if (!$agendamento) {
            return $this->render('confirma/erro_token');
        }

        $this->banhoModel->update($agendamento['id'], ['status' => 'cancelado']);

        return $this->render('confirma/sucesso', [
            'mensagem' => 'Banho & Tosa cancelado com sucesso!'
        ]);
    }
}
