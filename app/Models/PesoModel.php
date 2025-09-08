<?php

namespace App\Models;

use CodeIgniter\Model;

class PesoModel extends Model
{
    protected $table = 'pesos';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'pet_id',
        'data_registro',
        'peso_kg',
        'escala_condicao_corporal',
        'observacoes',
    ];

    protected $returnType = 'array';
    
}
