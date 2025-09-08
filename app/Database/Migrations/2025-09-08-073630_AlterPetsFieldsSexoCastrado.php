<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterPetsFieldsSexoCastrado extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('pets', [
            'castrado' => [
                'type'       => "ENUM('sim','nao','indefinido')",
                'null'       => false,
                'default'    => 'indefinido',
            ],
        ]);

        $this->forge->modifyColumn('pets', [
            'sexo' => [
                'type'       => "ENUM('M','F','I')",
                'null'       => false,
                'default'    => 'I',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('pets', [
            'castrado' => [
                'type'       => "ENUM('sim','nao')",
                'null'       => false,
                'default'    => 'nao',
            ],
        ]);

        $this->forge->modifyColumn('pets', [
            'sexo' => [
                'type'       => "ENUM('M','F')",
                'null'       => false,
                'default'    => 'M',
            ],
        ]);
    }
}
