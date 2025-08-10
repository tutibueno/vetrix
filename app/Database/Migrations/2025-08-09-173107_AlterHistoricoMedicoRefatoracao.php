<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterHistoricoMedicoRefatoracao extends Migration
{
    public function up()
    {
        // Renomear colunas existentes
        $this->forge->modifyColumn('historico_medico', [
            'sintomas' => [
                'name' => 'anamnese',
                'type' => 'TEXT',
                'null' => true,
            ],
            'tratamento' => [
                'name' => 'prescricao_medica',
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        // Adicionar novas colunas
        $this->forge->addColumn('historico_medico', [
            'sinais_clinicos' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'anamnese'
            ],
            'solicitacao_exame' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'prescricao_medica'
            ],
        ]);
    }

    public function down()
    {
        // Reverter nomes
        $this->forge->modifyColumn('historico_medico', [
            'anamnese' => [
                'name' => 'sintomas',
                'type' => 'TEXT',
                'null' => true,
            ],
            'prescricao_medica' => [
                'name' => 'tratamento',
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        // Remover novas colunas
        $this->forge->dropColumn('historico_medico', ['sinais_clinicos', 'solicitacao_exame']);
    }
}
