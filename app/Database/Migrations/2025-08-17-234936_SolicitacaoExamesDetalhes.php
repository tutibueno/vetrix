<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SolicitacaoExamesDetalhes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'solicitacao_id' => ['type' => 'INT', 'unsigned' => true],
            'nome_exame'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'observacoes'    => ['type' => 'TEXT', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => false],
            'updated_at'     => ['type' => 'DATETIME', 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('solicitacao_id', 'solicitacoes_exames', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('solicitacao_exames_detalhes');
    }

    public function down()
    {
        $this->forge->dropTable('solicitacao_exames_detalhes');
    }
}
