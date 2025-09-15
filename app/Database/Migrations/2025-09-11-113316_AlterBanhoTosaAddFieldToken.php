<?php 

use CodeIgniter\Database\Migration;

class AlterBanhoTosaAddFieldToken extends Migration
{
    public function up()
    {
        $this->forge->addColumn('banho_tosa', [
            'token' => [
                'type'       => 'VARCHAR(64)',
                'null'       => true,
                'after'      => 'status'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('banho_tosa', 'token');
    }
}