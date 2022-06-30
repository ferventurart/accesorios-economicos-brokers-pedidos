<?php

namespace App\Controllers;

use App\Models\RolModel;
use Hermawan\DataTables\DataTable;
use CodeIgniter\API\ResponseTrait;

class Rol extends BaseController
{
    use ResponseTrait;
    protected RolModel $model;

    function __construct()
    {
        $this->rolModel = new RolModel();
    }

    public function index()
    {
        return view('rol/index', ['title' => 'Roles de Usuario']);
    }

    public function getRoles()
    {
        $builder = $this->rolModel->select('id, nombre, descripcion');
        return DataTable::of($builder)
            ->add('action', function ($row) {
                return '<button type="button" class="btn btn-primary btn-sm" 
                onclick="obtener(\'' . $row->id . '\')"><i class="fas fa-edit"></i>&nbsp;Editar</button>&nbsp;
                <button type="button" class="btn btn-danger btn-sm" 
                onclick="borrar(\'' . $row->id . '\')"><i class="fas fa-trash"></i>&nbsp;Borrar</button>';
            }, 'last')
            
            ->toJson();
    }

    public function saveRoles()
    {
        try {
            $form = $this->request->getPost();
            if (count($form) > 0) {
                if ($this->rolModel->save($form)) {
                    configure_flash_alert('success', 'Informaci&oacute;n almacenada.', 'El registro fue guardado exitosamente.');
                } else {
                    configure_flash_alert('warning', 'No se pudo almacenar la informaci&oacute;n.', 'El registro no pudo ser guardado.');
                }
                return redirect()->to('/roles');
            }
        } catch (\Throwable $th) {
            configure_flash_alert('danger', 'No se pudo almacenar la informaci&oacute;n.', 'Ocurrio un error inesperado en el sistema.');
            return redirect()->to('/roles');
        }
    }

    public function getRol($id)
    {
        if ($this->request->isAJAX()) {
            if (!isset($id)) {
                return $this->fail('Falto pasar el valor del identificador.', 400);
            }
            $rol = $this->rolModel->find($id);
            if (!isset($rol)) {
                return $this->failNotFound('No se encontro el registro con el identificador ' . $id);
            }
            return $this->respond($rol, 200);
        }
    }

    public function deleteRol($id)
    {
        if ($this->request->isAJAX()) {
            if (!isset($id)) {
                return $this->fail('Falto pasar el valor del identificador.', 400);
            }
            $rol = $this->rolModel->find($id);
            if (!isset($rol)) {
                return $this->failNotFound('No se encontro el registro con el identificador ' . $id);
            }
            $this->rolModel->delete($id);
            return $this->respond($rol, 200);
        }
    }
}
