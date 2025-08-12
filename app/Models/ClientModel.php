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
        'cpf_cnpj'     => 'required|is_unique[clients.cpf_cnpj,id,{id}]',
        'telefone'     => 'required',
        'email'        => 'permit_empty|valid_email',
        'cep'          => 'required',
        'data_nascimento' => 'required|valid_date',
    ];
}
