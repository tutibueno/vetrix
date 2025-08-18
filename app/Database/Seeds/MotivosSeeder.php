<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MotivosSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'solicitacao_id' => 5,
                'motivo_suspeita' => 'Suspeita de anemia'
            ],
            [
                'solicitacao_id' => 5,
                'motivo_suspeita' => 'Avaliação pré-operatória'
            ],
            [
                'solicitacao_id' => 6,
                'motivo_suspeita' => 'Dores abdominais recorrentes'
            ],
        ];

        $this->db->table('solicitacao_exames_motivos')->insertBatch($data);
    }
}
