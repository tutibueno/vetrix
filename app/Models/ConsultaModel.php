<?php

namespace App\Models;

use CodeIgniter\Model;

class ConsultaModel extends Model
{
    protected $table = 'consultas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'pet_id',
        'veterinario_id',
        'data_consulta',
        'flag_retorno',
        'motivo',
        'observacoes',
        'status'
    ];
    protected $useTimestamps = true;

    // Retornar consulta já com dados de Pet e Veterinário
    public function getWithRelations()
    {
        return $this->select('consultas.*, pets.nome AS pet_nome, veterinarios.nome AS vet_nome, clients.nome as cliente_nome')
            ->join('pets', 'pets.id = consultas.pet_id')
            ->join('veterinarios', 'veterinarios.id = consultas.veterinario_id')
            ->join('clients', 'pets.cliente_id = clients.id')
            ->orderBy('data_consulta', 'DESC')
            ->findAll();
    }
}
