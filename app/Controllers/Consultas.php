<?php

namespace App\Controllers;

use App\Models\ConsultaModel;
use App\Models\PetModel;
use App\Models\VeterinarioModel;

class Consultas extends BaseController
{
    protected $consultaModel;
    protected $petModel;
    protected $vetModel;

    public function __construct()
    {
        $this->consultaModel = new ConsultaModel();
        $this->petModel = new PetModel();
        $this->vetModel = new VeterinarioModel();
    }

    public function index()
    {
        $consultas = $this->consultaModel->getWithRelations();
        return view('consultas/index', ['consultas' => $consultas]);
    }

    public function create()
    {
        $pets = $this->petModel->findAll();
        $veterinarios = $this->vetModel->findAll();
        return view('consultas/form', [
            'pets' => $pets,
            'veterinarios' => $veterinarios,
            'consulta' => null
        ]);
    }

    public function store()
    {
        $this->consultaModel->save($this->request->getPost());
        return redirect()->to('/consultas')->with('success', 'Consulta agendada com sucesso!');
    }

    public function edit($id)
    {
        $consulta = $this->consultaModel->find($id);
        $pets = $this->petModel->findAll();
        $veterinarios = $this->vetModel->findAll();
        return view('consultas/form', [
            'consulta' => $consulta,
            'pets' => $pets,
            'veterinarios' => $veterinarios
        ]);
    }

    public function update($id)
    {
        $this->consultaModel->update($id, $this->request->getPost());
        return redirect()->to('/consultas')->with('success', 'Consulta atualizada com sucesso!');
    }

    public function delete($id)
    {
        $this->consultaModel->delete($id);
        return redirect()->to('/consultas')->with('success', 'Consulta excluída!');
    }

    public function agenda()
    {
        return view('consultas/agenda');
    }

    public function agendaJson()
    {
        $consultas = $this->consultaModel->getWithRelations();

        $events = [];
        foreach ($consultas as $c) {
            $events[] = [
                'id' => $c['id'],
                'title' => $c['pet_nome'] . ' - ' . $c['vet_nome'],
                'start' => $c['data_consulta'],
                'url' => site_url('consultas/edit/' . $c['id']),
                'backgroundColor' => $c['status'] == 'agendada' ? '#007bff' : ($c['status'] == 'realizada' ? '#28a745' : '#dc3545'),
                'borderColor' => '#000000',
            ];
        }

        return $this->response->setJSON($events);
    }
}
