<?php

namespace App\Models;

use CodeIgniter\Model;

class SolicitacaoExameModel extends Model
{
    protected $table = 'solicitacoes_exames';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pet_id', 'veterinario_id', 'data_solicitacao', 'observacoes'];

    protected $useSoftDeletes   = false;
    protected $useTimestamps = true;
}
