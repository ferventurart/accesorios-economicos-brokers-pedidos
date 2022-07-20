<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;

class ProductoModel extends Model
{
    protected $table      = 'productos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'precio_broker', 'precio_venta', 'categoria_id', 'descripcion', 'sku', 'codigo_barra', 'imagen_producto', 'activo'];
    protected $useTimestamps  = false;
    protected $skipValidation = false;
}
