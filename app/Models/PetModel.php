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
        'foto', 
        'esta_vivo',
        'alergias',
        'numero_identificacao',
        'castrado',
        'peso',
        'pelagem'
    ];
    protected $useTimestamps    = true;

    protected $validationRules = [
        'cliente_id'             => 'required|is_natural_no_zero',
        'nome'                   => 'required|min_length[2]',
        'especie'                => 'required',
        'raca'                   => 'permit_empty',
        'sexo'                   => 'permit_empty|in_list[M,F]',
        'cor'                    => 'permit_empty',
        'data_nascimento'        => 'permit_empty|valid_date',
        'observacoes'            => 'permit_empty',
        'foto'                   => 'permit_empty',
        'esta_vivo'              => 'permit_empty',
        'alergias'               => 'permit_empty',
        'numero_identificacao'   => 'permit_empty',
        'castrado'               => 'permit_empty',
        'peso'                   => 'permit_empty',
        'pelagem'                => 'permit_empty',
    ];
}
