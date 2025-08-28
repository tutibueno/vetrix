<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        
        $userModel = new \App\Models\UserModel();

        $userModel->insert([
            'username'   => 'admin',
            'name'       => 'Administrador',
            'email'      => 'admin@vetrix.com.br',
            'password'   => password_hash('123456', PASSWORD_DEFAULT),
            'perfil'     => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $userModel->insert([
            'username'  => 'vet',
            'name'      => 'Dr. Veterinário',
            'email'     => 'veterinario@vetrix.com.br',
            'password'  => password_hash('123456', PASSWORD_DEFAULT),
            'perfil'    => 'veterinario',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $userModel->insert([
            'username'  => 'recepcao',
            'name'      => 'Recepcionista',
            'email'     => 'recepcao@vetrix.com.br',
            'password'  => password_hash('123456', PASSWORD_DEFAULT),
            'perfil'    => 'recepcionista',
            'created_at' => date('Y-m-d H:i:s'),
        ]);


        
    }
}
