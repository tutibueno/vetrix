<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePrescricaoMedicamentosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'prescricao_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'nome_medicamento' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'tipo_receita' => [
                'type'       => 'ENUM("Simples","Fórmula Manipulada")',
                'null'       => false,
            ],
            'tipo_farmacia' => [
                'type'       => 'ENUM("Humana","Veterinária")',
                'null'       => true,
            ],
            'via' => [
                'type'       => 'ENUM("Oral","Tópico","Oftálmico","Otológico","Ambiente")',
                'null'       => true,
            ],
            'posologia' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'quantidade' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'observacoes' => [
                'type' => 'TEXT',
                'null' => true,
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

        // Relacionamento com prescricoes
        $this->forge->addForeignKey('prescricao_id', 'prescricoes', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('prescricao_medicamentos');
    }

    public function down()
    {
        $this->forge->dropTable('prescricao_medicamentos');
    }
}
