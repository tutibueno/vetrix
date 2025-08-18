<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PetModel;
use App\Models\ClientModel;

class Pet extends BaseController
{
    protected $petModel;
    protected $clienteModel;

    public function __construct()
    {
        $this->petModel     = new PetModel();
        $this->clienteModel = new ClientModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        $pets = $this->petModel
            ->select('pets.*, clients.nome as tutor')
            ->join('clients', 'clients.id = pets.cliente_id');

        if ($search) {
            $pets->groupStart()
                ->like('pets.nome', $search)
                ->orLike('clients.nome', $search)
                ->groupEnd();
        }

        return view('pets/index', [
            'pets' => $pets->paginate(10),
            'pager' => $this->petModel->pager,
            'search' => $search
        ]);
    }

    public function create()
    {
        return view('pets/create', [
            'clientes' => $this->clienteModel->findAll()
        ]);
    }

    public function store()
    {
        $post = $this->request->getPost();

        // Upload da foto
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/pets', $newName);
            $post['foto'] = $newName; // <- Isso é ESSENCIAL
        }

        if (!$this->validate($this->petModel->getValidationRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->petModel->insert($post);
        return redirect()->to('/pet')->with('success', 'Pet cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $pet = $this->petModel->find($id);
        if (!$pet) {
            return redirect()->to('/pet')->with('error', 'Pet não encontrado.');
        }

        return view('pets/edit', [
            'pet' => $pet,
            'clientes' => $this->clienteModel->findAll()
        ]);
    }

    public function update($id)
    {
        $post = $this->request->getPost();

        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Deleta a foto anterior
            $old = $this->petModel->find($id);
            if ($old && $old['foto'] && file_exists('uploads/pets/' . $old['foto'])) {
                unlink('uploads/pets/' . $old['foto']);
            }

            $newName = $file->getRandomName();
            $file->move('uploads/pets', $newName);
            $post['foto'] = $newName;
        }

        if (!$this->validate($this->petModel->getValidationRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->petModel->update($id, $post);
        return redirect()->to('/pet')->with('success', 'Pet atualizado com sucesso!');
    }

    public function delete($id)
    {
        $this->petModel->delete($id);
        return redirect()->to('/pet')->with('error', 'Pet removido com sucesso');
    }

    public function ficha($id)
    {
        $pet = $this->petModel
            ->select('pets.*, clients.nome as nome_tutor, clients.telefone')
            ->join('clients', 'clients.id = pets.cliente_id')
            ->find($id);

        if (!$pet) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Pet não encontrado.");
        }

        $historicoModel = new \App\Models\HistoricoMedicoModel();
        $vacinaModel = new \App\Models\VacinaModel();
        $prescricaoModel = new \App\Models\PrescricaoModel();
        $medicamentoModel = new \App\Models\PrescricaoMedicamentoModel();

        $historico = $historicoModel
            ->select('historico_medico.*, veterinarios.nome as veterinario_nome')
            ->join('veterinarios', 'veterinarios.id = historico_medico.veterinario_id', 'left')
            ->where('historico_medico.pet_id', $id)
            ->orderBy('historico_medico.data_consulta', 'desc')
            ->orderBy('historico_medico.id', 'desc')
            ->findAll();

        $vacinas = $vacinaModel
            ->select('vacinas.*, veterinarios.nome as veterinario_nome')
            ->join('veterinarios', 'veterinarios.id = vacinas.veterinario_id', 'left')
            ->where('vacinas.pet_id', $id)
            ->orderBy('vacinas.data_aplicacao', 'desc')
            ->orderBy('vacinas.id', 'desc')
            ->findAll();


        // Prescrições do pet
        $prescricoes = $prescricaoModel
            ->select('prescricoes.*, veterinarios.nome AS veterinario_nome')
            ->join('veterinarios', 'veterinarios.id = prescricoes.veterinario_id', 'left')
            ->where('prescricoes.pet_id', $id)
            ->orderBy('prescricoes.data_prescricao', 'DESC')
            ->findAll();

        // Adiciona medicamentos de cada prescrição
        foreach ($prescricoes as &$prescricao) {
            $prescricao['medicamentos'] = $medicamentoModel
                ->where('prescricao_id', $prescricao['id'])
                ->findAll();
        }


        //5 Solicitações de Exame
        $exameModel = new \App\Models\SolicitacaoExameModel();
        $exameItemModel = new \App\Models\SolicitacaoExameDetalheModel();
        $motivoModel = new \App\Models\SolicitacaoExameMotivoModel();


        $exames = $exameModel
            ->select('solicitacoes_exames.*, veterinarios.nome as veterinario_nome')
            ->join('veterinarios', 'veterinarios.id = solicitacoes_exames.veterinario_id')
            ->where('pet_id', $id)
            ->orderBy('data_solicitacao', 'DESC')
            ->findAll();

        // 5.1️⃣ Para cada exame, buscar itens e motivos
        foreach ($exames as &$exame) {
            $exame['itens'] = $exameItemModel
                ->where('solicitacao_id', $exame['id'])
                ->orderBy('id', 'ASC')
                ->findAll();

            $exame['motivos'] = $motivoModel
                ->where('solicitacao_id', $exame['id'])
                ->orderBy('id', 'ASC')
                ->findAll();
        }

        return view('pets/ficha', compact('pet', 'historico', 'vacinas', 'prescricoes','exames'));
    }

}
