<?php

namespace App\Models;

use CodeIgniter\Model;

class ClinicaModel extends Model
{
    protected $table = 'clinica';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nome_clinica',
        'crmv',
        'razao_social',
        'cnpj',
        'registro_mapa',
        'inscricao_municipal',
        'inscricao_estadual',
        'cep',
        'rua',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'telefone',
        'celular',
        'whatsapp',
        'email',
    ];
    protected $useTimestamps = true;
}
