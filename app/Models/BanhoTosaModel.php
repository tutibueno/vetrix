<?php

namespace App\Models;

use CodeIgniter\Model;

class BanhoTosaModel extends Model
{
    protected $table = 'banho_tosa';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'pet_id',
        'servico_id',
        'data_hora_inicio',
        'data_hora_fim',
        'observacoes',
        'status',
        'token'
    ];

    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
}