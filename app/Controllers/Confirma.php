<?php

namespace App\Controllers;

use App\Models\ConsultaModel;
use App\Models\PetModel;
use App\Models\ClientModel;
use App\Models\VeterinarioModel;

class Confirma extends BaseController
{
    protected $consultaModel;
    protected $petModel;
    protected $clientModel;
    protected $vetModel;

    public function __construct()
    {
        $this->consultaModel = new ConsultaModel();
        $this->petModel = new PetModel();
        $this->clientModel = new ClientModel();
        $this->vetModel = new VeterinarioModel();
    }

    // Página inicial de confirmação
    public function index($token)
    {
        $consulta = $this->consultaModel->where('token', $token)->first();

        if (!$consulta) {
            return view('confirma/erro_token');
        }

        $pet = $this->petModel->find($consulta['pet_id']);
        $cliente = $this->clientModel->find($pet['cliente_id']);
        $veterinario = $this->vetModel->find($consulta['veterinario_id']);

        $consulta['tutor_nome'] = $cliente['nome'];
        $consulta['pet_nome'] = $pet['nome'];
        $consulta['veterinario_nome'] = $veterinario['nome'];

        return view('confirma/index', ['consulta' => $consulta]);
    }

    // Confirmar consulta
    public function confirmar($token)
    {
        $this->consultaModel->where('token', $token)->set(['status' => 'confirmada'])->update();
        return view('confirma/sucesso', ['mensagem' => 'Consulta confirmada com sucesso!']);
    }

    // Cancelar consulta
    public function cancelar($token)
    {
        $this->consultaModel->where('token', $token)->set(['status' => 'cancelada'])->update();
        return view('confirma/sucesso', ['mensagem' => 'Consulta cancelada com sucesso!']);
    }
}
