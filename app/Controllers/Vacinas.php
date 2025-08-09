<?php

namespace App\Controllers;

use App\Models\VacinaModel;
use App\Models\VeterinarioModel;

class Vacinas extends BaseController
{
    public function nova($pet_id)
    {
        $veterinarioModel = new VeterinarioModel();

        return view('vacinas/_form', [
            'action' => site_url('vacinas/store'),
            'pet_id' => $pet_id,
            'veterinarios' => $veterinarioModel->findAll()
        ]);
    }

    public function store()
    {
        $vacinaModel = new VacinaModel();

        $data = [
            'pet_id'         => $this->request->getPost('pet_id'),
            'veterinario_id' => $this->request->getPost('veterinario_id'),
            'nome_vacina'    => $this->request->getPost('nome_vacina'),
            'data_aplicacao' => $this->request->getPost('data_aplicacao'),
            'data_reforco'   => $this->request->getPost('data_reforco'),
            'observacoes'    => $this->request->getPost('observacoes'),
        ];

        if ($vacinaModel->insert($data)) {
            return redirect()->to(site_url('pets/ficha/' . $data['pet_id']))->with('success', 'Vacina adicionada com sucesso.');
        } else {
            return redirect()->back()->with('error', 'Erro ao salvar vacina.');
        }
    }

    public function editar($id)
    {
        $vacinaModel = new VacinaModel();
        $veterinarioModel = new VeterinarioModel();

        $vacina = $vacinaModel->find($id);
        if (!$vacina) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Vacina não encontrada");
        }

        return view('vacinas/_form', [
            'action' => site_url('vacinas/update/' . $id),
            'vacina' => $vacina,
            'pet_id' => $vacina['pet_id'],
            'veterinarios' => $veterinarioModel->findAll()
        ]);
    }

    public function update($id)
    {
        $vacinaModel = new VacinaModel();

        $data = [
            'veterinario_id' => $this->request->getPost('veterinario_id'),
            'nome_vacina'    => $this->request->getPost('nome_vacina'),
            'data_aplicacao' => $this->request->getPost('data_aplicacao'),
            'data_reforco'   => $this->request->getPost('data_reforco'),
            'observacoes'    => $this->request->getPost('observacoes'),
        ];

        $vacina = $vacinaModel->find($id);
        if ($vacinaModel->update($id, $data)) {
            return redirect()->to(site_url('pets/ficha/' . $vacina['pet_id']))->with('success', 'Vacina atualizada com sucesso.');
        } else {
            return redirect()->back()->with('error', 'Erro ao atualizar vacina.');
        }
    }

    public function delete($id)
    {
        $vacinaModel = new VacinaModel();
        $vacina = $vacinaModel->find($id);

        if ($vacina && $vacinaModel->delete($id)) {
            return redirect()->to(site_url('pets/ficha/' . $vacina['pet_id']))->with('success', 'Vacina removida.');
        } else {
            return redirect()->back()->with('error', 'Erro ao remover vacina.');
        }
    }
}
