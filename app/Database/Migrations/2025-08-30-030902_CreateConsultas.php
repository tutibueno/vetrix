<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConsultas extends Migration
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
            'pet_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'veterinario_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'data_consulta' => [
                'type' => 'DATETIME',
            ],
            'motivo' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'observacoes' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['agendada', 'realizada', 'cancelada'],
                'default'    => 'agendada',
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pet_id', 'pets', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('veterinario_id', 'veterinarios', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('consultas');
    }

    public function down()
    {
        $this->forge->dropTable('consultas');
    }
}
