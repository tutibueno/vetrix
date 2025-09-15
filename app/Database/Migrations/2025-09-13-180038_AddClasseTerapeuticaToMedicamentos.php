<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClasseTerapeuticaToMedicamentos extends Migration
{
    public function up()
    {
        $this->forge->addColumn('medicamentos', [
            'classe_terapeutica' => [
                'type'       => 'VARCHAR(255)',
                'null'       => true,
                'after'      => 'categoria'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('medicamentos', 'classe_terapeutica');
    }
}
