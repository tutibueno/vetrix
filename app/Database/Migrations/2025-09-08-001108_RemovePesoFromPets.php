<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemovePesoFromPets extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('pets', 'peso');
    }

    public function down()
    {
        //
    }
}
