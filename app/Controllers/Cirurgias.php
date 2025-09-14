<?php

namespace App\Controllers;

use App\Models\CirurgiaModel;
use App\Models\CirurgiaDetalheModel;
use App\Models\PetModel;
use App\Models\VeterinarioModel;

class Cirurgias extends BaseController
{
    protected $cirurgiaModel;
    protected $cirurgiaDetalheModel;
    protected $petModel;
    protected $vetModel;

    public function __construct()
    {
        $this->cirurgiaModel = new CirurgiaModel();
        $this->cirurgiaDetalheModel  = new CirurgiaDetalheModel();
        $this->petModel = new PetModel();
        $this->vetModel = new VeterinarioModel();
    }

    // Lista todas as cirurgias
    public function index()
    {
        $cirurgias = $this->cirurgiaModel
            ->select('cirurgias.*, pets.nome as pet_nome')
            ->join('pets', 'pets.id = cirurgias.pet_id', 'left')
            ->orderBy('data_cirurgia', 'DESC')
            ->findAll();

        return view('cirurgias/index', [
            'cirurgias' => $cirurgias
        ]);
    }

    public function create($pet_id)
    {
        $data['pet'] = $this->petModel->find($pet_id);
        $data['veterinarios'] = $this->vetModel->findAll();
        // Define o primeiro veterinário como padrão
        if (!empty($data['veterinarios'])) {
            $data['default_vet_id'] = $data['veterinarios'][0]['id'];
        } else {
            $data['default_vet_id'] = null;
        }
        return view('cirurgias/create', $data);
    }

    public function store()
    {

        $db = \Config\Database::connect();
        $db->transStart();
        
        try {
            $dataCirurgia = [
                'pet_id'         => $this->request->getPost('pet_id'),
                'veterinario_id' => $this->request->getPost('veterinario_id'),
                'data_cirurgia'  => $this->request->getPost('data_cirurgia'),
                'observacoes'    => $this->request->getPost('observacoes'),
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s')
            ];

            // Salva cirurgia
            $this->cirurgiaModel->insert($dataCirurgia);
            $cirurgiaId = $this->cirurgiaModel->getInsertID();

            // Salva detalhes (pode ser mais de um)
            $detalhes = $this->request->getPost('detalhes');

            if (!empty($detalhes) && isset($detalhes['nome_cirurgia'])) {
                $rows = [];
                foreach ($detalhes['nome_cirurgia'] as $i => $nome) {
                    if (trim($nome) === '') continue;

                    $rows[] = [
                        'cirurgia_id'     => $cirurgiaId,
                        'nome_cirurgia'   => $nome,
                        'materiais'       => $detalhes['materiais'][$i] ?? null,
                        'complicacoes'    => $detalhes['complicacoes'][$i] ?? null,
                        'created_at'      => date('Y-m-d H:i:s'),
                        'updated_at'      => date('Y-m-d H:i:s')
                    ];
                }

                if (!empty($rows)) {
                    $this->cirurgiaDetalheModel->insertBatch($rows);
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Erro ao salvar a cirurgia.'
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Cirurgia cadastrada com sucesso!'
            ]);
        } catch (\Exception $e) {
            $db->transRollback();

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Exceção: ' . $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        $cirurgia = $this->cirurgiaModel
            ->where('id', $id)
            ->first();

        if (!$cirurgia) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Cirurgia não encontrada.'
            ]);
        }

        $detalhes = $this->cirurgiaDetalheModel
            ->where('cirurgia_id', $id)
            ->findAll();

        $data = [
            'cirurgia' => $cirurgia,
            'detalhes' => $detalhes,
            'pet'      => $this->petModel->find($cirurgia['pet_id'])
        ];

        $data['veterinarios'] = $this->vetModel->findAll();

        return view('cirurgias/edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();

        if (!$id || empty($data)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Dados inválidos para atualização.'
            ]);
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Atualiza dados principais
            $this->cirurgiaModel->update($id, [
                'data_cirurgia'  => $data['data_cirurgia'] ?? null,
                'veterinario_id' => $data['veterinario_id'] ?? null,
                'observacoes'    => $data['observacoes'] ?? null,
                'updated_at'     => date('Y-m-d H:i:s')
            ]);

            // Limpa detalhes antigos
            $this->cirurgiaDetalheModel
                ->where('cirurgia_id', $id)
                ->delete();

            // Insere novos detalhes (se existirem)
            if (isset($data['detalhes']['nome_cirurgia']) && is_array($data['detalhes']['nome_cirurgia'])) {
                $detalhes = [];
                foreach ($data['detalhes']['nome_cirurgia'] as $i => $nome) {
                    if (trim($nome) === '') continue;

                    $detalhes[] = [
                        'cirurgia_id'      => $id,
                        'nome_cirurgia'    => $nome,
                        'materiais'        => $data['detalhes']['materiais'][$i] ?? null,
                        'complicacoes'     => $data['detalhes']['complicacoes'][$i] ?? null,
                        'created_at'       => date('Y-m-d H:i:s'),
                        'updated_at'       => date('Y-m-d H:i:s')
                    ];
                }

                if (!empty($detalhes)) {
                    $this->cirurgiaDetalheModel->insertBatch($detalhes);
                }
            }

            $db->transComplete();

            if (!$db->transStatus()) {
                throw new \Exception("Erro ao atualizar cirurgia.");
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Cirurgia atualizada com sucesso!'
            ]);
        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erro: ' . $e->getMessage()
            ]);
        }
    }


    // Retorna JSON para AJAX
    public function list()
    {
        // Busca todas as cirurgias com os pets
        $cirurgias = $this->cirurgiaModel
            ->select('cirurgias.*, pets.nome as pet_nome, veterinarios.nome as vet_nome')
            ->join('pets', 'pets.id = cirurgias.pet_id', 'left')
            ->join('veterinarios', 'veterinarios.id = cirurgias.veterinario_id', 'left')
            ->orderBy('data_cirurgia', 'DESC')
            ->findAll();

        // Para cada cirurgia, buscamos os detalhes relacionados
        foreach ($cirurgias as &$c) {
            $c['detalhes'] = $this->cirurgiaDetalheModel
                ->where('cirurgia_id', $c['id'])
                ->findAll();
        }

        return $this->response->setJSON($cirurgias);
    }

    public function delete($id)
    {
        $this->cirurgiaModel->delete($id);
        return redirect()->back()->with('success', 'Registro de cirurgia removido.');
    }
}
