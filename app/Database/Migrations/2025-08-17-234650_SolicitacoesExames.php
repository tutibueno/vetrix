<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SolicitacoesExames extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                 => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'pet_id'             => ['type' => 'INT', 'unsigned' => true],
            'veterinario_id'     => ['type' => 'INT', 'unsigned' => true],
            'data_solicitacao'   => ['type' => 'DATE', 'null' => false],
            'observacoes'        => ['type' => 'TEXT', 'null' => true],
            'created_at'         => ['type' => 'DATETIME', 'null' => false],
            'updated_at'         => ['type' => 'DATETIME', 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pet_id', 'pets', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('veterinario_id', 'veterinarios', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('solicitacoes_exames');
    }

    public function down()
    {
        $this->forge->dropTable('solicitacoes_exames');
    }
}
