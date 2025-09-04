<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBanhoTosa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
                'unsigned' => true,
            ],
            'pet_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'servico_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'data_agendamento' => [
                'type' => 'DATETIME',
            ],
            'duracao_minutos' => [
                'type' => 'INT',
                'null' => false,
            ],
            'observacoes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type' => "ENUM('agendado','em_andamento','concluido','cancelado')",
                'default' => 'agendado',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pet_id', 'pets', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('servico_id', 'servicos', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('banho_tosa');
    }

    public function down()
    {
        $this->forge->dropTable('banho_tosa');
    }
}
