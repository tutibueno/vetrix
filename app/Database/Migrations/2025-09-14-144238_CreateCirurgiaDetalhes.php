<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCirurgiaDetalhes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'cirurgia_id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nome_cirurgia'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'materiais'              => ['type' => 'TEXT', 'null' => true],
            'complicacoes'           => ['type' => 'TEXT', 'null' => true],
            'created_at'             => ['type' => 'DATETIME', 'null' => true],
            'updated_at'             => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('cirurgia_id', 'cirurgias', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cirurgia_detalhes');
    }

    public function down()
    {
        $this->forge->dropTable('cirurgia_detalhes');
    }
}
