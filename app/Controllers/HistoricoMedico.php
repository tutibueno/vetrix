<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HistoricoMedicoModel;
use App\Models\VeterinarioModel;

class HistoricoMedico extends BaseController
{
    protected $historicoModel;
    protected $veterinarioModel;

    public function __construct()
    {
        $this->historicoModel = new HistoricoMedicoModel();
        $this->veterinarioModel = new VeterinarioModel();
    }

    // Listar históricos por pet
    public function index($pet_id)
    {
        $builder = $this->historicoModel->builder();

        $historicos = $builder
            ->select('historico_medico.*, veterinarios.nome as veterinario_nome')
            ->join('veterinarios', 'veterinarios.id = historico_medico.veterinario_id', 'left')
            ->where('pet_id', $pet_id)
            ->orderBy('data_consulta', 'DESC')
            ->get()
            ->getResult();

        return view('historico_medico/index', [
            'historicos' => $historicos,
            'pet_id' => $pet_id
        ]);
    }

    // Exibir formulário de criação
    public function create($pet_id)
    {
        $veterinarios = $this->veterinarioModel->findAll();

        return view('historico_medico/_form', [
            'action' => site_url('historico_medico/store'),
            'pet_id' => $pet_id,
            'veterinarios' => $veterinarios
        ]);
    }

    // Salvar novo histórico
    public function store()
    {
        $data = [
            'pet_id'         => $this->request->getPost('pet_id'),
            'veterinario_id' => $this->request->getPost('veterinario_id') ?: null,
            'data_consulta'  => $this->request->getPost('data_consulta'),
            'sintomas'       => $this->request->getPost('sintomas'),
            'diagnostico'    => $this->request->getPost('diagnostico'),
            'tratamento'     => $this->request->getPost('tratamento'),
            'observacoes'    => $this->request->getPost('observacoes'),
        ];

        if ($this->historicoModel->insert($data)) {
            return redirect()->to(site_url('pets/ficha/' . $data['pet_id']))
                ->with('success', 'Histórico médico criado com sucesso.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->historicoModel->errors());
        }
    }

    // Exibir formulário de edição
    public function edit($id)
    {
        $historico = $this->historicoModel->find($id);
        if (!$historico) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Histórico médico não encontrado.");
        }

        $veterinarios = $this->veterinarioModel->findAll();

        return view('historico_medico/_form', [
            'action' => site_url('historico_medico/update/' . $id),
            'historico' => $historico,
            'veterinarios' => $veterinarios,
            'pet_id' => $historico['pet_id']
        ]);
    }

    // Atualizar histórico
    public function update($id)
    {
        $historico = $this->historicoModel->find($id);
        if (!$historico) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Histórico médico não encontrado.");
        }

        $data = [
            'pet_id'         => $this->request->getPost('pet_id'),
            'veterinario_id' => $this->request->getPost('veterinario_id') ?: null,
            'data_consulta'  => $this->request->getPost('data_consulta'),
            'sintomas'       => $this->request->getPost('sintomas'),
            'diagnostico'    => $this->request->getPost('diagnostico'),
            'tratamento'     => $this->request->getPost('tratamento'),
            'observacoes'    => $this->request->getPost('observacoes'),
        ];

        if ($this->historicoModel->update($id, $data)) {
            return redirect()->to(site_url('pets/ficha/' . $data['pet_id']))
                ->with('success', 'Histórico médico atualizado com sucesso.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->historicoModel->errors());
        }
    }

    // Excluir histórico
    public function delete($id)
    {
        $historico = $this->historicoModel->find($id);
        if (!$historico) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Histórico médico não encontrado.");
        }

        $this->historicoModel->delete($id);

        return redirect()->to(site_url('historico_medico/index/' . $historico->pet_id))
            ->with('success', 'Histórico médico excluído com sucesso.');
    }
}
