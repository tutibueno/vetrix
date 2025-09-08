<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveTipoReceitaFromPrescricaoMedicamentos extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('prescricao_medicamentos', 'tipo_receita');
    }

    public function down()
    {
        //
    }
}
