<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHistoricoMedico extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
                'null'           => false
            ],
            'pet_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => false
            ],
            'data_consulta' => [
                'type' => 'DATE',
                'null' => true
            ],
            'sintomas' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'diagnostico' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'tratamento' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'veterinario' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ],
            'observacoes' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pet_id', 'pets', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('historico_medico', true, [
            'ENGINE' => 'InnoDB'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('historico_medico');
    }
}
