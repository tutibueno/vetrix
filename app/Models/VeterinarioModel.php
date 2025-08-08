<?php

namespace App\Models;

use CodeIgniter\Model;

class VeterinarioModel extends Model
{
    protected $table = 'veterinarios';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nome',
        'crmv',
        'telefone',
        'email',
        'especialidade',
        'observacoes'
    ];
    protected $useTimestamps = true;
}
