<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PesoModel;
use App\Models\PetModel;

class PesoController extends BaseController
{
    protected $pesoModel;
    protected $petModel;

    public function __construct()
    {
        $this->pesoModel = new PesoModel();
        $this->petModel = new PetModel();
    }

    public function create($pet_id)
    {
        $data['pet'] = $this->petModel->find($pet_id);
        return view('pesos/create', $data);
    }

    public function store()
    {
        $this->pesoModel->save([
            'pet_id' => $this->request->getPost('pet_id'),
            'data_registro' => $this->request->getPost('data_registro'),
            'peso_kg' => $this->request->getPost('peso_kg'),
            'escala_condicao_corporal' => $this->request->getPost('escala_condicao_corporal'),
            'observacoes' => $this->request->getPost('observacoes'),
        ]);

        return redirect()->back()->with('success', 'Registro de peso adicionado com sucesso!');
    }

    public function edit($id)
    {
        $data['peso'] = $this->pesoModel->find($id);
        $data['pet'] = $this->petModel->find($data['peso']['pet_id']);
        return view('pesos/edit', $data);
    }

    public function update($id)
    {
        $this->pesoModel->update($id, [
            'data_registro' => $this->request->getPost('data_registro'),
            'peso_kg' => $this->request->getPost('peso_kg'),
            'escala_condicao_corporal' => $this->request->getPost('escala_condicao_corporal'),
            'observacoes' => $this->request->getPost('observacoes'),
        ]);

        return redirect()->back()->with('success', 'Registro de peso atualizado com sucesso!');
    }

    public function delete($id)
    {
        $this->pesoModel->delete($id);
        return redirect()->back()->with('success', 'Registro de peso removido.');
    }

    public function listByPet($pet_id)
    {
        $pesos = $this->pesoModel
            ->where('pet_id', $pet_id)
            ->orderBy('data_registro', 'DESC')
            ->findAll();

        return $this->response->setJSON($pesos);
    }
}
