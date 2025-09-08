<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Servicos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'constraint' => 11, 'auto_increment' => true],
            'nome_servico'    => ['type' => 'VARCHAR', 'constraint' => 100],
            'duracao_padrao'  => ['type' => 'INT', 'null' => true, 'comment' => 'Duração em minutos'],
            'preco'           => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('servicos');

        // Inserir alguns serviços padrão
        $this->db->table('servicos')->insertBatch([
            ['nome_servico' => 'Banho Simples', 'duracao_padrao' => 60, 'preco' => 50.00],
            ['nome_servico' => 'Banho & Tosa Completa', 'duracao_padrao' => 120, 'preco' => 120.00],
            ['nome_servico' => 'Tosa Higiênica', 'duracao_padrao' => 90, 'preco' => 80.00],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('servicos');
    }
}
