<?php

namespace App\Models;

use CodeIgniter\Model;

class CirurgiaModel extends Model
{
    protected $table            = 'cirurgias';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'pet_id',
        'veterinario_id',
        'data_cirurgia',
        'observacoes'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
