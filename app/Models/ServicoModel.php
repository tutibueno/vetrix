<?php

namespace App\Models;

use CodeIgniter\Model;

class ServicoModel extends Model
{
    protected $table = 'servicos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome_servico', 'duracao_padrao', 'preco'];
    protected $useTimestamps = true;
}
