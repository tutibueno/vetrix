<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVacinas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'auto_increment' => true],
            'pet_id'            => ['type' => 'INT', 'unsigned' => true, 'null' => false],
            'nome_vacina'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'data_aplicacao'    => ['type' => 'DATE'],
            'data_reforco'      => ['type' => 'DATE', 'null' => true],
            'observacoes'       => ['type' => 'TEXT', 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pet_id', 'pets', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('vacinas');
    }

    public function down()
    {
        $this->forge->dropTable('vacinas');
    }
}
