<?php

namespace App\Models;

use CodeIgniter\Model;

class SolicitacaoExameMotivoModel extends Model
{
    protected $table = 'solicitacao_exames_motivos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['solicitacao_id', 'motivo_suspeita'];

    protected $useSoftDeletes   = false;
    // Caso queira que as datas sejam gerenciadas automaticamente
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = '';
}
