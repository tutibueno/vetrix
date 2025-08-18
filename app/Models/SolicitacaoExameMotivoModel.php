<?php

namespace App\Models;

use CodeIgniter\Model;

class SolicitacaoExameMotivoModel extends Model
{
    protected $table = 'solicitacao_exames_motivos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['solicitacao_id', 'motivo_suspeita'];

    protected $useSoftDeletes   = false;
    protected $useTimestamps = true;
}
