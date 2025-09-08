<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePesosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pet_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'data_registro' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'escala_condicao_corporal' => [
                'type' => 'TINYINT',
                'null' => true,
            ],
            'peso_kg' => [
                'type' => 'DECIMAL',
                'constraint' => '5,3', // permite 3 casas decimais
                'null' => false,
            ],
            'observacoes' => [
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
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pet_id', 'pets', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pesos');
    }

    public function down()
    {
        $this->forge->dropTable('pesos');
    }
}
