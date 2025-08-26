<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClinicaModel;

class ClinicaController extends BaseController
{
    protected $clinicaModel;

    public function __construct()
    {
        $this->clinicaModel = new ClinicaModel();
    }

    public function show()
    {     
        $clinica = $this->clinicaModel->first(); // sempre pega o ID 1

        if (!$clinica) {

            //cria um registro padrão de clíncia
            $clinica['nome_clinica'] = 'CLÍNICA VETERINÁRIA TEMP';

            $this->clinicaModel->insert($clinica);

            $clinica = $this->clinicaModel->first();

        }

        return view('clinica/edit', ['clinica' => $clinica]);
    }

    public function edit($id)
    {
        $clinica = $this->clinicaModel->first();
        return view('clinica/edit', ['clinica' => $clinica]);
    }

    public function update($id)
    {
        $this->clinicaModel->update($id, $this->request->getPost());
        return redirect()->to('/clinica')->with('success', 'Dados da clínica atualizados com sucesso!');
    }
}
