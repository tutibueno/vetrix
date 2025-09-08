<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PetModel;
use App\Models\ClientModel;
use \App\Models\PesoModel;

class Pet extends BaseController
{
    protected $petModel;
    protected $clienteModel;
    protected $pesoModel;

    public function __construct()
    {
        $this->petModel     = new PetModel();
        $this->clienteModel = new ClientModel();
        $this->pesoModel    = new PesoModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        $pets = $this->petModel
            ->select('pets.*, clients.nome as tutor, clients.telefone as telefone')
            ->join('clients', 'clients.id = pets.cliente_id');

        if ($search) {
            $pets->groupStart()
                ->like('pets.nome', $search)
                ->orLike('clients.nome', $search)
                ->groupEnd();
        }

        return view('pets/index', [
            'pets' => $pets->paginate(9),
            'pager' => $this->petModel->pager,
            'search' => $search
        ]);
    }

    public function create()
    {
        return view('pets/create');
    }

    public function store()
    {
        $post = $this->request->getPost();

        if (!$this->validate($this->petModel->getValidationRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $foto = $this->processaFoto();
        if($foto != '')
            $post['foto'] = $foto;

        // Se a data nascimento vazia, transforma em NULL
        if (empty(trim($post['data_nascimento'] ?? ''))) {
            $post['data_nascimento'] = null;
        }

        $id = $this->petModel->insert($post);
        return redirect()->to('/pet/ficha/' . $id)->with('success', 'Pet cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $pet = $this->petModel->find($id);
        if (!$pet) {
            return redirect()->to('/pet')->with('error', 'Pet não encontrado.');
        }

        return view('pets/edit', [
            'pet' => $pet,
            'cliente' => $this->clienteModel->find($pet['cliente_id'])
        ]);
    }

    public function update($id)
    {
        $post = $this->request->getPost();

        if (!$this->validate($this->petModel->getValidationRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $foto = $this->processaFoto();
        if ($foto != '')
            $post['foto'] = $foto;

        // Se a data nascimento vazia, transforma em NULL
        if (empty(trim($post['data_nascimento'] ?? ''))) {
            $post['data_nascimento'] = null;
        }

        $this->petModel->update($id, $post);
        return redirect()->to('/pet/ficha/' . $id)->with('success', 'Pet atualizado com sucesso!');
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

        $exameModel = new \App\Models\SolicitacaoExameModel();
        $exameItemModel = new \App\Models\SolicitacaoExameDetalheModel();
        $motivoModel = new \App\Models\SolicitacaoExameMotivoModel();

        $exames = $exameModel
            ->select('solicitacoes_exames.*, veterinarios.nome as veterinario_nome')
            ->join('veterinarios', 'veterinarios.id = solicitacoes_exames.veterinario_id')
            ->where('pet_id', $id)
            ->orderBy('data_solicitacao', 'DESC')
            ->findAll();

        //Para cada exame, buscar itens e motivos
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

        // Buscar a pesagem mais recente
        $pesoRecente = $this->pesoModel
            ->where('pet_id', $id)
            ->orderBy('data_registro', 'DESC')
            ->first(); // retorna apenas o mais recente

        $cirurgias = '';
        $consultas = '';
        $medicamentos = '';
        $agendamentos = '';

        return view('pets/ficha', compact('pet', 'pesoRecente', 'historico', 'vacinas', 'prescricoes','exames', 'cirurgias','consultas','medicamentos','agendamentos'));
    }

    public function processaFoto()
    {
        $newName = '';
        $foto = $this->request->getFile('foto');

        if($foto == null || $foto == '')
            $foto = $this->request->getFile('foto_camera');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {

            // Validar tipo
            $validTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($foto->getMimeType(), $validTypes)) {
                return redirect()->back()->with('error', 'Formato de imagem inválido.');
            }
            
            $newName = $foto->getRandomName();
            
            // Redimensionar se necessário
            $image = \Config\Services::image()
                ->withFile($foto->getTempName());

            if ($image->getWidth() > 1024) {
                $image->resize(1024, 1024, true); // mantém proporção
                $image->save('public/uploads/pets/' . $newName);
            }
        
        }

        return $newName;

    }

    public function buscar()
    {
        $term = $this->request->getGet('term');

        $petModel = $this->petModel;

        // Busca pets + junta com cliente
        $pets = $petModel
            ->select("
            pets.*,
            clients.nome AS tutor_nome,
            clients.telefone AS tutor_telefone,
            CONCAT(
                SUBSTRING(REPLACE(clients.cpf_cnpj, '.', ''), 1, 3),
                '.***.***.',
                SUBSTRING(REPLACE(clients.cpf_cnpj, '.', ''), 11, 2)
            ) AS tutor_cpf
        ")
            ->join('clients', 'clients.id = pets.cliente_id', 'left')
            ->groupStart()
            ->like('pets.nome', $term)
            ->orLike('pets.raca', $term)
            ->orLike('clients.nome', $term)
            ->groupEnd()
            ->limit(10)
            ->find();

        $result = [];

        foreach ($pets as $pet) {
            $result[] = [
                'id'             => $pet['id'],
                'nome'           => $pet['nome'],
                'especie'        => $pet['especie'],
                'raca'           => $pet['raca'],
                'tutor_nome'     => $pet['tutor_nome'] ?? 'Sem tutor',
                'tutor_cpf'      => $pet['tutor_cpf'] ?? '',
                'tutor_telefone' => $pet['tutor_telefone'] ?? ''
            ];
        }

        return $this->response->setJSON($result);
    }

    public function detalhes($id)
    {
        $petModel = $this->petModel;

        $pet = $petModel
            ->select("
            pets.*,
            clients.nome AS tutor_nome,
            clients.telefone AS tutor_telefone,
            CONCAT(
                SUBSTRING(REPLACE(clients.cpf_cnpj, '.', ''), 1, 3),
                '.***.***.',
                SUBSTRING(REPLACE(clients.cpf_cnpj, '.', ''), 11, 2)
            ) AS tutor_cpf
        ")
            ->join('clients', 'clients.id = pets.cliente_id', 'left')
            ->where('pets.id', $id)
            ->first();

        if (!$pet) {
            return $this->response->setJSON(['error' => 'Pet não encontrado']);
        }

        // Buscar a pesagem mais recente
        $pesoRecente = $this->pesoModel
            ->where('pet_id', $id)
            ->orderBy('data_registro', 'DESC')
            ->first(); // retorna apenas o mais recente

        $pet['peso'] = $pesoRecente ? $pesoRecente['peso_kg'] : 0;

        return $this->response->setJSON($pet);
    }

}
