<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'email', 'password', 'rol_id', 'activo', 'email_confirmado', 'telefono', 'fotografia_url'];
    protected $useTimestamps  = false;
    protected $skipValidation = false;
}
