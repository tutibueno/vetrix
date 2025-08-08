<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoToPets extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pets', [
            'foto' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'observacoes'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pets', 'foto');
    }
}
