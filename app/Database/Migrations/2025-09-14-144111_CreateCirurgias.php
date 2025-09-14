<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCirurgias extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'pet_id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'data_cirurgia'  => ['type' => 'DATE', 'null' => false],
            'observacoes'    => ['type' => 'TEXT', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pet_id', 'pets', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cirurgias');
    }

    public function down()
    {
        $this->forge->dropTable('cirurgias');
    }
}
