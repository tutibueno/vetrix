<?php

namespace App\Controllers;

use App\Models\VacinaModel;

class Vacinas extends BaseController
{
    public function nova($pet_id)
    {
        return view('vacinas/create', ['pet_id' => $pet_id]);
    }

    public function salvar()
    {
        $model = new VacinaModel();

        $model->save([
            'pet_id'            => $this->request->getPost('pet_id'),
            'data_aplicacao'    => $this->request->getPost('data_aplicacao'),
            'nome_vacina'       => $this->request->getPost('nome_vacina'),
            'data_reforco'      => $this->request->getPost('data_reforco'),
            'veterinario'       => $this->request->getPost('veterinario'),
            'observacoes'       => $this->request->getPost('observacoes'),
        ]);

        return redirect()->to('/pets/ficha/' . $this->request->getPost('pet_id'));
    }
}
