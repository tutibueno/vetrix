<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFlagRetornoToConsultas extends Migration
{
    public function up()
    {
        $this->forge->addColumn('consultas', [
            'flag_retorno' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'default'    => 'N',
                'null'       => false,
                'after'      => 'data_consulta' // coloca logo depois de data_consulta
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('consultas', 'flag_retorno');
    }
}
