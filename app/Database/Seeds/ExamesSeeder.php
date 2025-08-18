<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ExamesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'solicitacao_id' => 5, // ajuste conforme o id de uma solicitação real
                'nome_exame'     => 'Hemograma Completo',
                'observacoes'    => 'Jejum de 8 horas recomendado'
            ],
            [
                'solicitacao_id' => 5,
                'nome_exame'     => 'Raio-X Tórax',
                'observacoes'    => 'Paciente deve estar em posição lateral'
            ],
            [
                'solicitacao_id' => 6,
                'nome_exame'     => 'Ultrassom Abdominal',
                'observacoes'    => 'Evitar alimentação 6 horas antes'
            ],
        ];

        $this->db->table('solicitacao_exames_detalhes')->insertBatch($data);
    }
}
