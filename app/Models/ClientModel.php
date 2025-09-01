<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table            = 'clients';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'nome',
        'cpf_cnpj',
        'telefone',
        'email',
        'rua',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'data_nascimento',
        'observacoes'
    ];

    protected $useTimestamps = true;
    protected $useSoftDeletes   = true;

    protected $validationRules = [
        'id'             => 'permit_empty|is_natural_no_zero',
        'nome'         => 'required|min_length[3]',
        'cpf_cnpj'     => 'permit_empty|is_unique[clients.cpf_cnpj,id,{id}]',
        'telefone'     => 'permit_empty',
        'email'        => 'permit_empty|valid_email',
        'cep'          => 'permit_empty',
        'data_nascimento' => 'permit_empty|valid_date',
    ];
}
