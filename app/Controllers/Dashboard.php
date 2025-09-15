<?php

namespace App\Controllers;

use App\Models\ConsultaModel;
use App\Models\BanhoTosaModel;
use App\Models\PetModel;
use App\Models\ClientModel;
use App\Models\VacinaModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $consultaModel = new ConsultaModel();
        $banhoModel    = new BanhoTosaModel();
        $petModel      = new PetModel();
        $clienteModel  = new ClientModel();
        $vacinaModel   = new VacinaModel();

        $hoje = date('Y-m-d');

        helper('cor_consulta_badge');

        // Contadores
        $data['consultasHoje']   = $consultaModel->where('DATE(data_consulta)', $hoje)->countAllResults();
        $data['consultasSemana'] = $consultaModel->where('YEARWEEK(data_consulta, 1)', date('oW'))->countAllResults();
        $data['banhosHoje']      = $banhoModel->where('DATE(data_hora_inicio)', $hoje)->countAllResults();
        $data['banhosSemana']    = $banhoModel->where('YEARWEEK(data_hora_inicio, 1)', date('oW'))->countAllResults();
        $data['totalPets']       = $petModel->countAllResults();
        $data['totalTutores']    = $clienteModel->countAllResults();

        // Consultas de hoje
        $data['consultasHojeLista'] = $consultaModel
            ->select("consultas.*, pets.nome AS pet_nome, clients.nome AS tutor_nome, veterinarios.nome AS vet_nome")
            ->join("pets", "pets.id = consultas.pet_id", "left")
            ->join("clients", "clients.id = pets.cliente_id", "left")
            ->join("veterinarios", "veterinarios.id = consultas.veterinario_id", "left")
            ->where('DATE(data_consulta)', $hoje)
            ->orderBy('data_consulta', 'ASC')
            ->findAll();

        foreach ($data['consultasHojeLista'] as &$consulta) {
            $consulta['data_consulta_label'] = date('H:i', strtotime($consulta['data_consulta'])) . " (hoje)";
            $consulta['cor_badge'] = get_consulta_status_color_badge($consulta['status']);
        }

        // Próximas consultas (a partir de amanhã)
        $data['proximasConsultas'] = $consultaModel
            ->select("consultas.*, pets.nome AS pet_nome, clients.nome AS tutor_nome, veterinarios.nome AS vet_nome")
            ->join("pets", "pets.id = consultas.pet_id", "left")
            ->join("clients", "clients.id = pets.cliente_id", "left")
            ->join("veterinarios", "veterinarios.id = consultas.veterinario_id", "left")
            ->where('data_consulta >', $hoje . ' 23:59:59')
            ->orderBy('data_consulta', 'ASC')
            ->limit(5)
            ->findAll();

        foreach ($data['proximasConsultas'] as &$consulta) {
            $consulta['data_consulta_label'] = date('d/m/Y H:i', strtotime($consulta['data_consulta']));
            $consulta['cor_badge'] = get_consulta_status_color_badge($consulta['status']);
        }

        // Banhos & Tosa de hoje
        $data['banhosHojeLista'] = $banhoModel
            ->select("banho_tosa.*, pets.nome AS pet_nome, servicos.nome_servico AS servico_nome")
            ->join("pets", "pets.id = banho_tosa.pet_id", "left")
            ->join("servicos", "servicos.id = banho_tosa.servico_id", "left")
            ->where('DATE(banho_tosa.data_hora_inicio)', $hoje)
            ->orderBy('banho_tosa.data_hora_inicio', 'ASC')
            ->findAll();

        // Próximos banhos
        $data['proximosBanhos'] = $banhoModel
            ->select("banho_tosa.*, pets.nome AS pet_nome, servicos.nome_servico AS servico_nome")
            ->join("pets", "pets.id = banho_tosa.pet_id", "left")
            ->join("servicos", "servicos.id = banho_tosa.servico_id", "left")
            ->where('DATE(banho_tosa.data_hora_inicio) >', $hoje)
            ->orderBy('banho_tosa.data_hora_inicio', 'ASC')
            ->limit(5)
            ->findAll();

        // Gráfico últimos 30 dias: Consultas e Banhos & Tosa
        $dias = [];
        $valoresConsultas = [];
        $valoresBanhos    = [];

        for ($i = 29; $i >= 0; $i--) {
            $dia = date('Y-m-d', strtotime("-$i days"));
            $dias[] = date('d/m', strtotime($dia));

            // Contagem consultas
            $valoresConsultas[] = $consultaModel->where('DATE(data_consulta)', $dia)->countAllResults();

            // Contagem banhos
            $valoresBanhos[] = $banhoModel->where('DATE(data_hora_inicio)', $dia)->countAllResults();
        }

        $data['dias']             = $dias;
        $data['valoresConsultas'] = $valoresConsultas;
        $data['valoresBanhos']    = $valoresBanhos;

        // Alertas (igual ao seu código)
        $alertas = [];

        // Vacinas vencidas
        $vacinasVencidas = $vacinaModel
            ->select("vacinas.*, pets.id AS pet_id, pets.nome AS pet_nome")
            ->join("pets", "pets.id = vacinas.pet_id", "left")
            ->where('data_reforco <', $hoje)
            ->findAll();
        foreach ($vacinasVencidas as $v) {
            $alertas[] = [
                'mensagem' => "❌ Vacina <b>{$v['nome_vacina']}</b> do pet <b>{$v['pet_nome']}</b> está vencida!",
                'pet_id'   => $v['pet_id']
            ];
        }

        // Vacinas a vencer
        $vacinasAVencer = $vacinaModel
            ->select("vacinas.*, pets.id AS pet_id, pets.nome AS pet_nome")
            ->join("pets", "pets.id = vacinas.pet_id", "left")
            ->where('data_reforco >=', $hoje)
            ->where('data_reforco <=', date('Y-m-d', strtotime('+7 days')))
            ->findAll();
        foreach ($vacinasAVencer as $v) {
            $diasRestantes = (new \DateTime($v['data_reforco']))->diff(new \DateTime())->days;
            $alertas[] = [
                'mensagem' => "⚠️ Vacina <b>{$v['nome_vacina']}</b> do pet <b>{$v['pet_nome']}</b> vence em {$diasRestantes} dias.",
                'pet_id'   => $v['pet_id']
            ];
        }

        $data['alertas'] = $alertas;

        return view('dashboard', $data);
    }
}
