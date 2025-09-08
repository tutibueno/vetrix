<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table      = 'clients';
    protected $primaryKey = 'id';

    protected $useSoftDeletes = true;

    protected $allowedFields = [
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
        'observacoes',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $useTimestamps = true;

    protected $validationRules = [
        'nome'            => 'required|min_length[3]|max_length[100]',
        'cpf_cnpj'        => 'permit_empty|max_length[20]|is_unique[clients.cpf_cnpj,id,{id}]',
        'telefone'        => 'permit_empty|max_length[20]',
        'email'           => 'permit_empty|valid_email|max_length[100]',
        'rua'             => 'permit_empty|max_length[100]',
        'numero'          => 'permit_empty|max_length[10]',
        'complemento'     => 'permit_empty|max_length[150]',
        'bairro'          => 'permit_empty|max_length[50]',
        'cidade'          => 'permit_empty|max_length[50]',
        'estado'          => 'permit_empty|exact_length[2]',
        'cep'             => 'permit_empty|max_length[10]',
        'data_nascimento' => 'permit_empty|valid_date',
        'observacoes'     => 'permit_empty',
    ];

    protected $validationMessages = [
        'nome' => [
            'required'    => 'O campo Nome é obrigatório.',
            'min_length'  => 'O Nome deve ter pelo menos 3 caracteres.',
            'max_length'  => 'O Nome não pode passar de 100 caracteres.'
        ],
        'cpf_cnpj' => [
            'is_unique'   => 'Esse CPF/CNPJ já está cadastrado.'
        ],
        'email' => [
            'valid_email' => 'Digite um e-mail válido.'
        ],
        'estado' => [
            'exact_length' => 'O estado deve ter exatamente 2 caracteres (UF).'
        ],
    ];
}
