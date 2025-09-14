<?php

namespace App\Models;

use CodeIgniter\Model;

class CirurgiaDetalheModel extends Model
{
    protected $table            = 'cirurgia_detalhes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'cirurgia_id',
        'nome_cirurgia',
        'materiais',
        'complicacoes'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
