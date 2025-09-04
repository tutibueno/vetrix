<?php

namespace App\Controllers;

use App\Models\ConsultaModel;
use App\Models\PetModel;
use App\Models\ClientModel;
use App\Models\VacinaModel;


class Dashboard extends BaseController
{

    public function index()
    {
        $consultaModel = new ConsultaModel();
        $petModel = new PetModel();
        $clienteModel = new ClientModel();
        $vacinaModel = new VacinaModel();

        $data['consultasHoje']   = $consultaModel->where('DATE(data_consulta)', date('Y-m-d'))->countAllResults();
        $data['consultasSemana'] = $consultaModel->where('YEARWEEK(data_consulta, 1)', date('oW'))->countAllResults();
        $data['totalPets']       = $petModel->countAllResults();
        $data['totalTutores']    = $clienteModel->countAllResults();

        // Consultas de hoje
        $data['consultasHojeLista'] = $consultaModel
            ->select("consultas.*, pets.nome AS pet_nome, clients.nome AS tutor_nome, veterinarios.nome AS vet_nome")
            ->join("pets", "pets.id = consultas.pet_id", "left")
            ->join("clients", "clients.id = pets.cliente_id", "left")
            ->join("veterinarios", "veterinarios.id = consultas.veterinario_id", "left")
            ->where('DATE(data_consulta)', date('Y-m-d'))
            ->orderBy('data_consulta', 'ASC')
            ->findAll();

        foreach ($data['consultasHojeLista'] as &$consulta) {
            $consulta['data_consulta_label'] = date('H:i', strtotime($consulta['data_consulta'])) . " (hoje)";
        }

        // Próximas consultas (a partir de amanhã)
        $data['proximasConsultas'] = $consultaModel
            ->select("consultas.*, pets.nome AS pet_nome, clients.nome AS tutor_nome, veterinarios.nome AS vet_nome")
            ->join("pets", "pets.id = consultas.pet_id", "left")
            ->join("clients", "clients.id = pets.cliente_id", "left")
            ->join("veterinarios", "veterinarios.id = consultas.veterinario_id", "left")
            ->where('data_consulta >', date('Y-m-d 23:59:59'))
            ->orderBy('data_consulta', 'ASC')
            ->limit(5)
            ->findAll();

        foreach ($data['proximasConsultas'] as &$consulta) {
            $consulta['data_consulta_label'] = date('d/m/Y H:i', strtotime($consulta['data_consulta']));
        }


        // Gráfico últimos 30 dias
        $dias = [];
        $valores = [];
        for ($i = 29; $i >= 0; $i--) {
            $dia = date('Y-m-d', strtotime("-$i days"));
            $dias[] = date('d/m', strtotime($dia));
            $valores[] = $consultaModel->where('DATE(data_consulta)', $dia)->countAllResults();
        }
        $data['dias'] = $dias;
        $data['valores'] = $valores;

        // ----------- ALERTAS -----------
        $alertas = [];

        // 1. Vacinas vencidas
        $vacinasVencidas = $vacinaModel
            ->select("vacinas.*, pets.id AS pet_id, pets.nome AS pet_nome")
            ->join("pets", "pets.id = vacinas.pet_id", "left")
            ->where('data_reforco <', date('Y-m-d'))
            ->findAll();

        foreach ($vacinasVencidas as $v) {
            $alertas[] = [
                'mensagem' => "❌ Vacina <b>{$v['nome_vacina']}</b> do pet <b>{$v['pet_nome']}</b> está vencida!",
                'pet_id'   => $v['pet_id']
            ];
        }

        // 2. Vacinas vencendo nos próximos 7 dias
        $vacinasAVencer = $vacinaModel
            ->select("vacinas.*, pets.id AS pet_id, pets.nome AS pet_nome")
            ->join("pets", "pets.id = vacinas.pet_id", "left")
            ->where('data_reforco >=', date('Y-m-d'))
            ->where('data_reforco <=', date('Y-m-d', strtotime('+7 days')))
            ->findAll();

        foreach ($vacinasAVencer as $v) {
            $diasRestantes = (new \DateTime($v['data_reforco']))->diff(new \DateTime())->days;
            $alertas[] = [
                'mensagem' => "⚠️ Vacina <b>{$v['nome_vacina']}</b> do pet <b>{$v['pet_nome']}</b> vence em {$diasRestantes} dias.",
                'pet_id'   => $v['pet_id']
            ];
        }

        // 3. Pets sem histórico
        $petsSemHistorico = $petModel
            ->select("pets.id, pets.nome")
            ->join("historico_medico", "historico_medico.pet_id = pets.id", "left")
            ->where("historico_medico.id IS NULL")
            ->findAll();

        foreach ($petsSemHistorico as $p) {
            $alertas[] = [
                'mensagem' => "📋 Pet <b>{$p['nome']}</b> ainda não possui histórico médico.",
                'pet_id'   => $p['id']
            ];
        }

        $data['alertas'] = $alertas;


        return view('dashboard', $data);
    }
}
