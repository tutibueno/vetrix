<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVeterinarioToCirurgias extends Migration
{
    public function up()
    {
        $this->forge->addColumn('cirurgias', [
            'veterinario_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'after'      => 'pet_id' // coloca logo depois de data_consulta
            ]
        ]);
        $this->forge->addForeignKey('veterinario_id', 'veterinarios', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropColumn('cirurgias', 'veterinario_id');
    }
}
