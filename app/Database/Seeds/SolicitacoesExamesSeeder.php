<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SolicitacoesExamesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'pet_id'                    => 1, // precisa já existir um pet
                'veterinario_id'            => 1, 
                'data_solicitacao'          => date('Y-m-d H:i:s'),
                'observacoes_gerais'        => 'Primeira avaliação clínica com exames de rotina'
            ],
            [
                'pet_id'                    => 1, // outro pet
                'veterinario_id'            => 1, 
                'data_solicitacao'          => date('Y-m-d H:i:s'),
                'observacoes_gerais'        => 'Solicitação devido a sintomas digestivos'
            ],
        ];

        $this->db->table('solicitacoes_exames')->insertBatch($data);
    }
}
