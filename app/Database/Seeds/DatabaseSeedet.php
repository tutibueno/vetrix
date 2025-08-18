<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Ordem é importante!
        $this->call('SolicitacoesExamesSeeder');
        $this->call('ExamesSeeder');
        $this->call('MotivosSeeder');

        // Caso você já tenha PetsSeeder ou outro, pode chamar aqui também
        // $this->call('PetsSeeder');
    }
}
