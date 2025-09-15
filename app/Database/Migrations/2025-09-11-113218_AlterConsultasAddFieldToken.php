<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterConsultasAddFieldToken extends Migration
{
    public function up()
    {
        $this->forge->addColumn('consultas', [
            'token' => [
                'type'       => 'VARCHAR(64)',
                'null'       => true,
                'after'      => 'status'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('consultas', 'token');
    }
}
