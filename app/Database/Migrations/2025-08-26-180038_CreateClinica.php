<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClinica extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'auto_increment' => true],
            'nome_clinica'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'crmv'              => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'razao_social'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'cnpj'              => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'registro_mapa'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'inscricao_municipal' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'inscricao_estadual'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'cep'               => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'rua'               => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'numero'            => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'complemento'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'bairro'            => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'cidade'            => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'uf'                => ['type' => 'CHAR', 'constraint' => 2, 'null' => true],
            'telefone'          => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'celular'           => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'whatsapp'          => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'email'             => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('clinica');
    }

    public function down()
    {
        $this->forge->dropTable('clinica');
    }
}
