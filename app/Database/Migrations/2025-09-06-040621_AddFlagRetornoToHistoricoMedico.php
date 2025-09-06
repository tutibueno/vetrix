<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFlagRetornoToHistoricoMedico extends Migration
{
    public function up()
    {
        $this->forge->addColumn('historico_medico', [
            'flag_retorno' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'null'       => false,
                'default'    => 'N',
                'after'      => 'data_consulta'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('historico_medico', 'flag_retorno');
    }
}
