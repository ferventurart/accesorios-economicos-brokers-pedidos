<?php

namespace App\Models;

use CodeIgniter\Model;

class RolModel extends Model
{
    protected $table      = 'roles_usuarios';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'descripcion'];
    protected $useTimestamps  = false;
    protected $skipValidation = false;
}
