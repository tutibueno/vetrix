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
        'data_agendamento',
        'duracao_minutos',
        'observacoes',
        'status'
    ];

    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
}