<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCategoriaToMedicamentos extends Migration
{
    public function up()
    {
        $this->forge->addColumn('medicamentos', [
            'categoria' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'forma', // insere logo após o campo 'forma'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('medicamentos', 'categoria');
    }
}
