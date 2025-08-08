<?php

namespace App\Models;

use CodeIgniter\Model;

class PetModel extends Model
{
    protected $table            = 'pets';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'cliente_id',
        'nome',
        'especie',
        'raca',
        'sexo',
        'cor',
        'data_nascimento',
        'observacoes',
        'foto'
    ];
    protected $useTimestamps    = true;

    protected $validationRules = [
        'cliente_id'      => 'required|is_natural_no_zero',
        'nome'            => 'required|min_length[2]',
        'especie'         => 'required',
        'raca'            => 'permit_empty',
        'sexo'            => 'required|in_list[M,F]',
        'cor'             => 'permit_empty',
        'data_nascimento' => 'permit_empty|valid_date',
        'observacoes'     => 'permit_empty',
        'foto'            => 'permit_empty',
    ];
}
