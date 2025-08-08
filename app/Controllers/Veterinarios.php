<?php

namespace App\Controllers;

use App\Models\VeterinarioModel;

class Veterinarios extends BaseController
{
    public function index()
    {
        $model = new VeterinarioModel();
        $data['veterinarios'] = $model->findAll();
        return view('veterinarios/index', $data);
    }

    public function create()
    {
        return view('veterinarios/create');
    }

    public function store()
    {
        $model = new VeterinarioModel();
        $model->save($this->request->getPost());
        return redirect()->to('/veterinarios')->with('success', 'Veterinário cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $model = new VeterinarioModel();
        $data['veterinario'] = $model->find($id);
        return view('veterinarios/edit', $data);
    }

    public function update($id)
    {
        $model = new VeterinarioModel();
        $model->update($id, $this->request->getPost());
        return redirect()->to('/veterinarios')->with('success', 'Veterinário atualizado com sucesso!');
    }

    public function delete($id)
    {
        $model = new VeterinarioModel();
        $model->delete($id);
        return redirect()->to('/veterinarios')->with('success', 'Veterinário removido com sucesso!');
    }
}
