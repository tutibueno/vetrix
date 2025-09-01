<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePrescricoesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'data_prescricao' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'pet_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'veterinario_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'tipo_prescricao' => [
                'type'       => 'ENUM("Simples","Controle Especial")',
                'null'       => false,
            ],
            'instrucoes_gerais' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        // Relacionamentos
        $this->forge->addForeignKey('pet_id', 'pets', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('veterinario_id', 'veterinarios', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('prescricoes');
    }

    public function down()
    {
        $this->forge->dropTable('prescricoes');
    }
}
