<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterStatusAddConfirmado extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('banho_tosa', [
            'status' => [
                'type'       => "ENUM('agendado','confirmado','em_andamento','concluido','cancelado')",
                'null'       => false,
                'default'    => 'agendado',
            ],
        ]);

        $this->forge->modifyColumn('consultas', [
            'status' => [
                'type'       => "ENUM('agendada','confirmada','realizada','cancelada')",
                'null'       => false,
                'default'    => 'agendada',
            ],
        ]);
    }

    public function down()
    {
        // Reverte para o ENUM anterior (sem 'confirmado')
        $this->forge->modifyColumn('banho_tosa', [
            'status' => [
                'type'       => "ENUM('agendado','em_andamento','concluido','cancelado')",
                'null'       => false,
                'default'    => 'agendado',
            ],
        ]);

        $this->forge->modifyColumn('consultas', [
            'status' => [
                'type'       => "ENUM('agendada','realizada','cancelada')",
                'null'       => false,
                'default'    => 'agendada',
            ],
        ]);


    }
}
