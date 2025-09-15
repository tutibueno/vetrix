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

        helper('cor_consulta');

        // Calcula data_consulta_fim (30 min depois)
        foreach ($consultas as &$c) {
            $c['data_consulta_fim'] = date('Y-m-d H:i:s', strtotime($c['data_consulta'] . ' +30 minutes'));
            $c['cor_status'] = get_consulta_status_color($c['status']);
        }
        unset($c); // evita referência residual

        return view('consultas/index', [
            'consultas' => $consultas
        ]);
    }

    public function create()
    {
        $pets = $this->petModel->findAll();
        $veterinarios = $this->vetModel->findAll();
        return view('consultas/_form', [
            'pets' => $pets,
            'veterinarios' => $veterinarios,
            'consulta' => null
        ]);
    }

    public function store()
    {
        $data = $this->request->getPost();

        // Gerar token único
        $data['token'] = bin2hex(random_bytes(16));

        $this->consultaModel->save($data);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Consulta criada com sucesso'
        ]);
    }

    public function edit($id)
    {
        $consulta = $this->consultaModel->select('consultas.*, pets.nome as pet_nome')
            ->join('pets', 'pets.id = consultas.pet_id')
            ->where('consultas.id', $id)
            ->first();
        $veterinarios = $this->vetModel->findAll();
        return view('consultas/_form', [
            'consulta' => $consulta,
            'veterinarios' => $veterinarios
        ]);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        
        if (empty($data['token'])) {
            $data['token'] = bin2hex(random_bytes(16));
        }
        
        $this->consultaModel->update($id, $data);
        return $this->response->setJSON(['success' => true, 'message' => 'Consulta atualizada com sucesso']);
    }

    public function delete($id)
    {
        $this->consultaModel->delete($id);
        return $this->response->setJSON(['success' => true, 'message' => 'Consulta removida com sucesso']);
    }

    public function agendaJson()
    {
        $consultas = $this->consultaModel->getWithRelations();

        $events = [];

        helper('cor_consulta');

        foreach ($consultas as $c) {
            $c['data_consulta_fim'] = date('Y-m-d H:i:s', strtotime($c['data_consulta'] . ' +30 minutes'));
            $c['cor_status'] = get_consulta_status_color($c['status']);
            
            $status = strtolower($c['status'] ?? '');

            $map = [
                'confirmada' => ['bg' => '#28a745', 'border' => '#28a745', 'text' => '#ffffff', 'class' => 'evt-confirmada'],
                'pendente'   => ['bg' => '#ffc107', 'border' => '#ffc107', 'text' => '#000000', 'class' => 'evt-pendente'],
                'cancelada'  => ['bg' => '#dc3545', 'border' => '#dc3545', 'text' => '#ffffff', 'class' => 'evt-cancelada'],
            ];
            $cfg = $map[$status] ?? ['bg' => '#3788d8', 'border' => '#3788d8', 'text' => '#ffffff', 'class' => 'evt-default'];

            $events[] = [
                'id'              => $c['id'],
                'title'           => ($c['flag_retorno'] == 'S' ? ' (R) ' : '') . $c['pet_nome'] . ' - ' . $c['vet_nome'],
                'start'           => date('c', strtotime($c['data_consulta'])),
                'end'             => date('c', strtotime($c['data_consulta_fim'])),
                'allDay'          => false, // força a mostrar a hora
                //'url'             => site_url('consultas/edit/' . $c['id']),
                'backgroundColor' => $c['cor_status'],
                'color'           => $c['cor_status'],
                'borderColor'     => $cfg['border'],
                'textColor'       => $cfg['text'],
                'classNames'      => [$cfg['class']],
                'extendedProps'   => ['status' => ucfirst($c['status']),
                                        'pet' => $c['pet_nome'],
                                        'vet' => $c['vet_nome'],
                                        'retorno' => $c['flag_retorno']
                                    ]
            ];
        }

        return $this->response->setJSON($events);
    }

    public function eventos()
    {

        $consultas = $this->consultaModel
            ->select("consultas.id, consultas.data_consulta, pets.nome AS pet_nome, veterinarios.nome AS vet_nome")
            ->join("pets", "pets.id = consultas.pet_id", "left")
            ->join("veterinarios", "veterinarios.id = consultas.veterinario_id", "left")
            ->findAll();

        $eventos = [];
        foreach ($consultas as $c) {
            $eventos[] = [
                'id'    => $c['id'],
                'title' => $c['pet_nome'] . ' - ' . $c['vet_nome'],
                'start' => $c['data_consulta'],
            ];
        }

        return $this->response->setJSON($eventos);
    }

    public function detalhes($id)
    {
        $model = new \App\Models\BanhoTosaModel();

        $agendamento = $model
            ->select("banho_tosa.*, pets.nome AS pet_nome, clients.nome AS tutor_nome, clients.telefone AS tutor_telefone")
            ->join("pets", "pets.id = banho_tosa.pet_id", "left")
            ->join("clients", "clients.id = banho_tosa.cliente_id", "left")
            ->find($id);

        if (!$agendamento) {
            return $this->response->setStatusCode(404)->setBody('Agendamento não encontrado');
        }

        return view('banho_tosa/modal_detalhes', ['agendamento' => $agendamento]);
    }

    function enviarWhatsapp($telefone, $mensagem)
    {
        $token = 'SEU_ACCESS_TOKEN';
        $whatsapp_number_id = 'SEU_WHATSAPP_NUMBER_ID';

        $url = "https://graph.facebook.com/v16.0/$whatsapp_number_id/messages";

        $data = [
            "messaging_product" => "whatsapp",
            "to" => $telefone,
            "type" => "text",
            "text" => ["body" => $mensagem]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $token",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }
}
