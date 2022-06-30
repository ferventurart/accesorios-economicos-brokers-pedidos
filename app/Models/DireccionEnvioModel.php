<?php

namespace App\Models;

use CodeIgniter\Model;

class DireccionEnvioModel extends Model
{
    protected $table      = 'direcciones_envio';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['usuario_id', 'nombre', 'apellido', 'email', 'direccion', 'direccion_2', 'departamento', 'municipio'];
    protected $useTimestamps  = false;
    protected $skipValidation = false;
}
