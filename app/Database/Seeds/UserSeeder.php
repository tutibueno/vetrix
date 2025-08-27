<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'   => 'admin',
                'name'       => 'Administrador',
                'email'      => 'admin@vetrix.com.br',
                'password'   => password_hash('123456', PASSWORD_DEFAULT),
                'perfil'     => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username'  => 'vet',
                'name'      => 'Dr. Veterinário',
                'email'     => 'veterinario@vetrix.com.br',
                'senha'     => password_hash('123456', PASSWORD_DEFAULT),
                'perfil'    => 'veterinario',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'recepcao',
                'name'      => 'Recepcionista',
                'email'     => 'recepcao@vetrix.com.br',
                'senha'     => password_hash('123456', PASSWORD_DEFAULT),
                'perfil'    => 'recepcionista',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insert($data);
    }
}
