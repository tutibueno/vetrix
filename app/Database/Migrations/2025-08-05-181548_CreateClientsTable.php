<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClientsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nome'            => ['type' => 'VARCHAR', 'constraint' => 100],
            'cpf_cnpj'        => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'telefone'        => ['type' => 'VARCHAR', 'constraint' => 20],
            'email'           => ['type' => 'VARCHAR', 'constraint' => 100],
            'rua'             => ['type' => 'VARCHAR', 'constraint' => 100],
            'numero'          => ['type' => 'VARCHAR', 'constraint' => 10],
            'complemento'     => ['type' => 'VARCHAR', 'constraint' => 150],
            'bairro'          => ['type' => 'VARCHAR', 'constraint' => 50],
            'cidade'          => ['type' => 'VARCHAR', 'constraint' => 50],
            'estado'          => ['type' => 'VARCHAR', 'constraint' => 2],
            'cep'             => ['type' => 'VARCHAR', 'constraint' => 10],
            'data_nascimento' => ['type' => 'DATE'],
            'observacoes'     => ['type' => 'TEXT', 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('clients');
    }

    public function down()
    {
        $this->forge->dropTable('clients');
    }
}
