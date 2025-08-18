<?php

namespace App\Models;

use CodeIgniter\Model;

class SolicitacaoExameDetalheModel extends Model
{
    protected $table = 'solicitacao_exames_detalhes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['solicitacao_id', 'nome_exame', 'observacoes'];

    protected $useSoftDeletes   = false;
    // Caso queira que as datas sejam gerenciadas automaticamente
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = '';
}
