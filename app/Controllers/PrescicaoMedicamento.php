<?php

namespace App\Controllers;

use App\Models\PrescricaoModel;
use App\Models\PrescricaoMedicamentoModel;
use CodeIgniter\Controller;

class PrescricaoMedicamento extends Controller
{
    protected $prescricaoModel;
    protected $medicamentoModel;

    public function __construct()
    {
        $this->prescricaoModel = new PrescricaoModel();
        $this->medicamentoModel = new PrescricaoMedicamentoModel();
    }

    public function create($prescricao_id)
    {
        $data['prescricao'] = $this->prescricaoModel->find($prescricao_id);
        return view('prescricoes/medicamentos_form', $data);
    }

    public function store($prescricao_id)
    {
        $medicamentos = $this->request->getPost('medicamentos');

        if ($medicamentos && is_array($medicamentos)) {
            foreach ($medicamentos as $med) {
                $this->medicamentoModel->insert([
                    'prescricao_id'    => $prescricao_id,
                    'nome_medicamento' => $med['nome_medicamento'] ?? '',
                    'tipo_farmacia'    => $med['tipo_farmacia'] ?? '',
                    'via'              => $med['via'] ?? '',
                    'posologia'        => $med['posologia'] ?? '',
                    'quantidade'       => $med['quantidade'] ?? '',
                    'observacoes'      => $med['observacoes'] ?? '',
                ]);
            }
        }

        return redirect()->to("/prescricoes/{$prescricao_id}")->with('success', 'Medicamentos adicionados com sucesso!');
    }
}
