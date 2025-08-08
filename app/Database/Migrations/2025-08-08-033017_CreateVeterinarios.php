<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVeterinariosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nome'          => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'crmv'          => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'telefone'      => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'email'         => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'endereco'      => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'observacoes'   => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'created_at'    => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'    => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('veterinarios');
    }

    public function down()
    {
        $this->forge->dropTable('veterinarios');
    }
}
