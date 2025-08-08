<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVeterinarioToHistoricoMedico extends Migration
{
    public function up()
    {
        $this->forge->addColumn('historico_medico', [
            'veterinario_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'pet_id'
            ]
        ]);

        $this->db->query('ALTER TABLE historico_medico ADD CONSTRAINT fk_vet FOREIGN KEY (veterinario_id) REFERENCES veterinarios(id) ON DELETE SET NULL ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE historico_medico DROP FOREIGN KEY fk_vet');
        $this->forge->dropColumn('historico_medico', 'veterinario_id');
    }
}
