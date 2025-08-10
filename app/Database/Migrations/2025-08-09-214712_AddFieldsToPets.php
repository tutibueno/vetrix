<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsToPets extends Migration
{
    public function up()
    {
        $fields = [
            'esta_vivo' => [
                'type' => 'ENUM',
                'constraint' => ['sim', 'nao'],
                'default' => 'sim',
                'null' => false,
            ],
            'alergias' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'numero_identificacao' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'castrado' => [
                'type' => 'ENUM',
                'constraint' => ['sim', 'nao'],
                'default' => 'nao',
                'null' => false,
            ],
            'peso' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2', // exemplo 999.99 kg
                'null' => true,
            ],
            'pelagem' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
        ];
        $this->forge->addColumn('pets', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('pets', [
            'esta_vivo',
            'alergias',
            'numero_identificacao',
            'castrado',
            'peso',
            'pelagem',
        ]);
    }
}
