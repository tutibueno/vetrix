<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMedicamentos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nome_comercial'   => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'principio_ativo'  => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'especie_destino'  => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'forma'            => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'laboratorio'      => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'created_at'       => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at'       => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'deleted_at'       => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('medicamentos');
    }

    public function down()
    {
        $this->forge->dropTable('medicamentos');
    }
}
