<?php

namespace App\Models;

use CodeIgniter\Model;

class VacinaModel extends Model
{
    protected $table      = 'vacinas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'pet_id',
        'nome_vacina',
        'data_aplicacao',
        'data_reforco',
        'observacoes',
        'veterinario_id'
    ];

    public function getByPet($pet_id)
    {
        return $this->select('vacinas.*, veterinarios.nome as veterinario_nome')
            ->join('veterinarios', 'veterinarios.id = vacinas.veterinario_id', 'left')
            ->where('vacinas.pet_id', $pet_id)
            ->orderBy('data_aplicacao', 'DESC')
            ->findAll();
    }
}
