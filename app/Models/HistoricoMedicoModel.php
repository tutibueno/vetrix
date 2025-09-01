<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoricoMedicoModel extends Model
{
    protected $table      = 'historico_medico';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'pet_id',
        'veterinario_id',
        'data_consulta',
        'anamnese',
        'sinais_clinicos',
        'diagnostico',
        'prescricao_medica',
        'solicitacao_exame',
        'observacoes'
    ];

    protected $useTimestamps = true;
}