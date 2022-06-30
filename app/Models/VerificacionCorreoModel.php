<?php

namespace App\Models;

use CodeIgniter\Model;

class VerificacionCorreoModel extends Model
{
    protected $table      = 'verificaciones_correo';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['usuario_id', 'token', 'tipo', 'expira', 'expirado'];
    protected $useTimestamps  = false;
    protected $skipValidation = false;
}
