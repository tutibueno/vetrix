<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePetsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'cliente_id'       => ['type' => 'INT', 'unsigned' => true, 'null' => false],
            'nome'             => ['type' => 'VARCHAR', 'constraint' => 100],
            'especie'          => ['type' => 'VARCHAR', 'constraint' => 50],
            'raca'             => ['type' => 'VARCHAR', 'constraint' => 50],
            'sexo'             => ['type' => 'ENUM', 'constraint' => ['M', 'F']],
            'cor'              => ['type' => 'VARCHAR', 'constraint' => 30],
            'data_nascimento'  => ['type' => 'DATE', 'null' => true],
            'observacoes'      => ['type' => 'TEXT', 'null' => true],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('cliente_id', 'clients', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pets');
    }

    public function down()
    {
        $this->forge->dropTable('pets');
    }
}
