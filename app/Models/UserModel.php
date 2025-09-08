<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'username', 'email', 'password', 'perfil'];
    protected $useTimestamps = true;

    // Perfis disponíveis no sistema
    public const PERFIS = [
        'admin'         => 'Administrador',
        'veterinario'   => 'Veterinário',
        'recepcionista' => 'Recepcionista',
    ];

    /**
     * Retorna lista de perfis formatada para selects
     */
    public function getPerfis(): array
    {
        return self::PERFIS;
    }

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    
}