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
        'observacoes'
    ];

    protected $useTimestamps = true;
}