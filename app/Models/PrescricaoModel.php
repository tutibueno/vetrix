<?php

namespace App\Models;

use CodeIgniter\Model;

class PrescricaoModel extends Model
{
    protected $table            = 'prescricoes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $useTimestamps = true;

    protected $allowedFields    = [
        'data_prescricao',
        'pet_id',
        'veterinario_id',
        'tipo_prescricao',
        'instrucoes_gerais'
    ];

    // Validações básicas
    protected $validationRules = [
        'data_prescricao'   => 'required|valid_date',
        'pet_id'            => 'required|integer',
        'veterinario_id'    => 'required|integer',
        'tipo_prescricao'   => 'required|in_list[Simples,Controle Especial]',
        'instrucoes_gerais' => 'permit_empty|string'
    ];

    protected $validationMessages = [
        'data_prescricao' => [
            'required' => 'A data da prescrição é obrigatória.',
            'valid_date' => 'Informe uma data válida para a prescrição.'
        ],
        'pet_id' => [
            'required' => 'O pet é obrigatório.',
            'integer' => 'ID do pet inválido.'
        ],
        'veterinario_id' => [
            'required' => 'O veterinário é obrigatório.',
            'integer' => 'ID do veterinário inválido.'
        ],
        'tipo_prescricao' => [
            'required' => 'O tipo de prescrição é obrigatório.',
            'in_list'  => 'O tipo de prescrição deve ser "Simples" ou "Controle Especial".'
        ]
    ];

    protected $skipValidation = false;
}
