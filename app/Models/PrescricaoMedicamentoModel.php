<?php

namespace App\Models;

use CodeIgniter\Model;

class PrescricaoMedicamentoModel extends Model
{
    protected $table            = 'prescricao_medicamentos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'prescricao_id',
        'nome_medicamento',
        'tipo_receita',
        'tipo_farmacia',
        'via',
        'posologia',
        'quantidade',
        'observacoes'
    ];

    // Caso queira que as datas sejam gerenciadas automaticamente
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = '';

    // Validações básicas
    protected $validationRules = [
        'prescricao_id'    => 'required|integer',
        'nome_medicamento' => 'required|string|max_length[255]',
        'tipo_receita'     => 'required|in_list[Simples,Fórmula Manipulada]',
        'tipo_farmacia'    => 'required|in_list[Humana,Veterinária]',
        'via'              => 'required|in_list[Oral,Tópico,Oftálmico,Otológico,Ambiente]',
    ];

    protected $validationMessages = [
        'prescricao_id' => [
            'required' => 'A prescrição é obrigatória.',
            'integer'  => 'O ID da prescrição deve ser um número inteiro.'
        ],
        'nome_medicamento' => [
            'required'   => 'O nome do medicamento é obrigatório.',
            'max_length' => 'O nome do medicamento não pode exceder 255 caracteres.'
        ],
        'tipo_receita' => [
            'required' => 'O tipo de receita é obrigatório.',
            'in_list'  => 'Tipo de receita inválido.'
        ],
        'tipo_farmacia' => [
            'required' => 'O tipo de farmácia é obrigatório.',
            'in_list'  => 'Tipo de farmácia inválido.'
        ],
        'via' => [
            'required' => 'A via é obrigatória.',
            'in_list'  => 'Via inválida.'
        ],
    ];
}
