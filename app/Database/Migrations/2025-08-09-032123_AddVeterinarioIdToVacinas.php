<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVeterinarioIdToVacinas extends Migration
{
    public function up()
    {
        // Adiciona a coluna veterinario_id
        $this->forge->addColumn('vacinas', [
            'veterinario_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'pet_id'
            ]
        ]);

        // Adiciona a chave estrangeira
        $this->db->query('
            ALTER TABLE vacinas
            ADD CONSTRAINT fk_vacinas_veterinarios
            FOREIGN KEY (veterinario_id) REFERENCES veterinarios(id)
            ON DELETE SET NULL ON UPDATE CASCADE
        ');
    }

    public function down()
    {
        // Remove a chave estrangeira
        $this->db->query('ALTER TABLE vacinas DROP FOREIGN KEY fk_vacinas_veterinarios');

        // Remove a coluna
        $this->forge->dropColumn('vacinas', 'veterinario_id');
    }
}
