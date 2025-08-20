<?php

namespace App\Controllers;

use App\Models\PrescricaoModel;
use App\Models\PrescricaoMedicamentoModel;
use App\Models\VeterinarioModel;
use App\Models\ClientModel;
use App\Models\PetModel;
use CodeIgniter\Controller;
use App\Libraries\Mypdf;
use \Mpdf\Mpdf;

class Prescricoes extends Controller
{
    protected $prescricaoModel;
    protected $medicamentoModel;
    protected $db;

    public function __construct()
    {
        $this->prescricaoModel = new PrescricaoModel();
        $this->medicamentoModel = new PrescricaoMedicamentoModel();
        $this->db = \Config\Database::connect();
    }

    public function create($pet_id)
    {
        // Buscar pet para validar se existe, carregar veterinarios etc
        $petModel = new PetModel();
        $veterinarioModel = new VeterinarioModel();

        $pet = $petModel->find($pet_id);
        if (!$pet) {
            return redirect()->back()->with('error', 'Pet não encontrado.');
        }

        $veterinarios = $veterinarioModel->findAll();

        // Carrega a view parcial do formulário, passando pet e veterinários
        echo view('prescricoes/_form', [
            'pet_id' => $pet_id,
            'veterinarios' => $veterinarios,
            // outras variáveis que precisar
            'action' => site_url('prescricoes/store'),
        ]);
    }

    public function store()
    {
        $post = $this->request->getPost();

        // Validação básica
        $validationRules = [
            'pet_id'           => 'required|integer',
            'data_prescricao'  => 'required|valid_date[Y-m-d]',
            'veterinario_id'   => 'required|integer',
            'tipo_prescricao'  => 'required|string',
        ];

        if (!$this->validate($validationRules)) {
            var_dump($this->validator->getErrors());
            exit();
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Salva a prescrição
        $prescricaoData = [
            'pet_id'           => $post['pet_id'],
            'data_prescricao'  => $post['data_prescricao'],
            'veterinario_id'   => $post['veterinario_id'],
            'tipo_prescricao'  => $post['tipo_prescricao'],
            'instrucoes_gerais' => $post['instrucoes_gerais'] ?? null,
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s'),
        ];

        $prescricaoModel = new \App\Models\PrescricaoModel();
        $prescricaoId = $prescricaoModel->insert($prescricaoData);

        // Remove possíveis medicamentos antigos (se for update; aqui assumimos insert)
        // Salva os medicamentos associados
        $medicamentos = $post['medicamentos'] ?? [];
        $medModel = new \App\Models\PrescricaoMedicamentoModel();

        foreach ($medicamentos as $med) {
            $med['prescricao_id'] = $prescricaoId;
            $medModel->insert([
                'prescricao_id'     => $prescricaoId,
                'nome_medicamento'  => $med['nome_medicamento'],
                'tipo_receita'      => $med['tipo_receita'],
                'tipo_farmacia'     => $med['tipo_farmacia'],
                'via'               => $med['via'],
                'posologia'         => $med['posologia'],
                'quantidade'        => $med['quantidade'],
                'observacoes'       => $med['observacoes'] ?? null,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            var_dump("erro: " . $db->transStatus());
            exit();
            return redirect()->back()->withInput()->with('error', 'Erro ao salvar prescrição.');
        }

        return redirect()->to(site_url("pet/ficha/{$post['pet_id']}"))->with('success', 'Prescrição salva com sucesso!');
    }

    public function edit($id)
    {
        $prescricao = $this->prescricaoModel->find($id);
        if (!$prescricao) {
            return redirect()->to(site_url('prescricoes'))->with('error', 'Prescrição não encontrada');
        }

        $medicamentos = $this->medicamentoModel->where('prescricao_id', $id)->findAll();

        $data = [
            'action' => site_url('prescricoes/update/' . $id),
            'prescricao' => $prescricao,
            'medicamentos' => $medicamentos,
            'pets' => $this->getPetById($prescricao['pet_id']),
            'veterinarios' => $this->getVeterinarios(),
        ];

        //echo view('prescricoes/_form', $data);

        return view('prescricoes/_form', [
            'action' => site_url('prescricoes/update/' . $id),
            'prescricao' => $prescricao,
            'medicamentos' => $medicamentos,
            'pets' => $this->getPetById($prescricao['pet_id']),
            'veterinarios' => $this->getVeterinarios(),
        ]);
    }

    public function update($id)
    {
        $post = $this->request->getPost();

        $this->db->transStart();

        $prescricaoData = [
            'data_prescricao' => $post['data_prescricao'],
            'pet_id' => $post['pet_id'],
            'veterinario_id' => $post['veterinario_id'],
            'tipo_prescricao' => $post['tipo_prescricao'],
            'instrucoes_gerais' => $post['instrucoes_gerais'],
        ];

        if (!$this->prescricaoModel->update($id, $prescricaoData)) {
            $this->db->transRollback();
            return redirect()->back()->with('error', 'Erro ao atualizar a prescrição')->withInput();
        }

        // Excluir todos os medicamentos antigos e inserir os novos
        $this->medicamentoModel->where('prescricao_id', $id)->delete();

        if (!empty($post['medicamentos'])) {
            foreach ($post['medicamentos'] as $med) {
                $med['prescricao_id'] = $id;
                $this->medicamentoModel->insert($med);
            }
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->with('error', 'Erro na transação ao atualizar dados')->withInput();
        }

        return redirect()->to(site_url('pet/ficha/' . $post['pet_id']),null,'refresh');
    }

    public function index()
    {
        $prescricoes = $this->prescricaoModel->findAll();

        return view('prescricoes/index', ['prescricoes' => $prescricoes]);
    }

    public function delete($id)
    {
        $prescricao = $this->prescricaoModel->find($id);
        
        if (!$prescricao) {
            return redirect()->back()->with('error', 'Prescrição não encontrada');
        }

        $this->db->transStart();

        $this->medicamentoModel->where('prescricao_id', $id)->delete();
        $this->prescricaoModel->delete($id);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->with('error', 'Erro ao deletar prescrição');
        }

        return true;
    }

    public function excluirMedicamento($id)
    {
        $this->medicamentoModel->delete($id);
        return redirect()->back()->with('success', 'Medicamento excluído com sucesso!');
    }

    private function getPetById($id)
    {
        return model('PetModel')->find($id);
    }

    private function getVeterinarios()
    {
        return model('VeterinarioModel')->findAll();
    }

    public function imprimir($id)
    {
        $prescricaoModel = new PrescricaoModel();

        // Buscar prescrição
        $prescricao = $prescricaoModel->find($id);

        if (!$prescricao) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Prescrição não encontrada");
        }

        $medicamentoModel = new PrescricaoMedicamentoModel();
        $petModel = new PetModel();
        $clienteModel = new ClientModel();
        $veterinarioModel = new VeterinarioModel();

        // Buscar dados do pet
        $pet = $petModel->find($prescricao['pet_id']);

        // Calcular idade do pet
        $idadePet = '';
        if (!empty($pet['data_nascimento'])) {
            $dataNascimento = new \DateTime($pet['data_nascimento']);
            $hoje = new \DateTime();
            $idade = $hoje->diff($dataNascimento);

            $idadePet = $idade->y . ' ano';
            $idade->y == 0 || $idade->y > 1 ? $idadePet .= 's' : '';
            $idadePet .= ' e ' . $idade->m;
            $idade->m > 1 || $idade->m == 0 ? $idadePet .= ' meses' : $idadePet .= ' mês';

            $pet['data_nascimento'] == '0000-00-00' ? $idadePet = '' : $idadePet;
        }

        // Buscar cliente (tutor)
        $cliente = $clienteModel->find($pet['cliente_id']);

        // Buscar veterinário
        $veterinario = $veterinarioModel->find($prescricao['veterinario_id']);

        // Buscar medicamentos e agrupar por via
        $medicamentos = $medicamentoModel
            ->where('prescricao_id', $id)
            ->findAll();

        $medicamentosPorVia = [];
        foreach ($medicamentos as $med) {
            $via = $med['via'];
            if (!isset($medicamentosPorVia[$via])) {
                $medicamentosPorVia[$via] = [];
            }
            $medicamentosPorVia[$via][] = $med;
        }

        $info_clinica = [];
        $info_clinica['nome_clinica'] = 'CLINICA VETERINÁRIA';
        $info_clinica['crmv_clinica'] ='';
        $info_clinica['razao_social'] = '';
        $info_clinica['cnpj'] = '';
        $info_clinica['registro_mapa'] = '';
        $info_clinica['inscricao_municipal'] = '';
        $info_clinica['inscricao_estadual'] = '';
        $info_clinica['rua'] = 'Rua Teodureto Souto';
        $info_clinica['numero'] = '577';
        $info_clinica['complemento'] = '(paralelo à av. Lins de Vasconcelos)';
        $info_clinica['cep'] = '01536-000';
        $info_clinica['cidade'] = 'São Paulo';
        $info_clinica['uf'] = 'SP';
        $info_clinica['bairro'] = 'Cambuci';
        $info_clinica['telefone'] = '11-3206-7266';
        $info_clinica['celular'] = '(11)99987-9989';
        $info_clinica['whatsapp'] = '(11)99988-9989';
        $info_clinica['email'] = 'clinica_vet@gmail.com';

        $dados = [
            'prescricao' => $prescricao,
            'pet' => $pet,
            'idade_pet' => $idadePet,
            'cliente' => $cliente,
            'veterinario' => $veterinario,
            'medicamentosPorVia' => $medicamentosPorVia,
            'info_clinica' => $info_clinica
        ];

        return view('prescricoes/imprimir', $dados);
    }

    public function imprimirPdf($id)
    {
        $prescricaoModel = new PrescricaoModel();

        // Buscar prescrição
        $prescricao = $prescricaoModel->find($id);

        if (!$prescricao) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Prescrição não encontrada");
        }

        $medicamentoModel = new PrescricaoMedicamentoModel();
        $petModel = new PetModel();
        $clienteModel = new ClientModel();
        $veterinarioModel = new VeterinarioModel();

        // Buscar dados do pet
        $pet = $petModel->find($prescricao['pet_id']);

        // Calcular idade do pet
        $idadePet = '';
        if (!empty($pet['data_nascimento'])) {
            $dataNascimento = new \DateTime($pet['data_nascimento']);
            $hoje = new \DateTime();
            $idade = $hoje->diff($dataNascimento);

            $idadePet = $idade->y . ' ano';
            $idade->y == 0 || $idade->y > 1 ? $idadePet .= 's' : '';
            $idadePet .= ' e ' . $idade->m;
            $idade->m > 1 || $idade->m == 0 ? $idadePet .= ' meses' : $idadePet .= ' mês';

            $pet['data_nascimento'] == '0000-00-00' ? $idadePet = '' : $idadePet;
        }

        // Buscar cliente (tutor)
        $cliente = $clienteModel->find($pet['cliente_id']);

        // Buscar veterinário
        $veterinario = $veterinarioModel->find($prescricao['veterinario_id']);

        // Buscar medicamentos e agrupar por via
        $medicamentos = $medicamentoModel
            ->where('prescricao_id', $id)
            ->findAll();

        $medicamentosPorVia = [];
        foreach ($medicamentos as $med) {
            $via = $med['via'];
            if (!isset($medicamentosPorVia[$via])) {
                $medicamentosPorVia[$via] = [];
            }
            $medicamentosPorVia[$via][] = $med;
        }

        $info_clinica = [];
        $info_clinica['rua'] = 'Rua Teodureto Souto';
        $info_clinica['numero'] = '577';
        $info_clinica['complemento'] = '(paralelo à av. Lins de Vasconcelos)';
        $info_clinica['cep'] = '01536-000';
        $info_clinica['cidade'] = 'São Paulo';
        $info_clinica['uf'] = 'SP';
        $info_clinica['bairro'] = 'Cambuci';
        $info_clinica['telefone'] = '11-3206-7266';
        $info_clinica['celular'] = '(11)99987-9989';
        $info_clinica['whatsapp'] = '(11)99988-9989';
        $info_clinica['email'] = 'clinica_vet@gmail.com';

        $dados = [
            'prescricao' => $prescricao,
            'pet' => $pet,
            'idade_pet' => $idadePet,
            'cliente' => $cliente,
            'veterinario' => $veterinario,
            'medicamentosPorVia' => $medicamentosPorVia,
            'info_clinica' => $info_clinica
        ];

        // Carregar view em HTML
        $html = view('prescricoes/imprimir', $dados);

        
        //$mpdf = new Mpdf();
        //$mpdf->WriteHTML($html);
        //return $mpdf->Output('filename.pdf', 'D');

    }
}
