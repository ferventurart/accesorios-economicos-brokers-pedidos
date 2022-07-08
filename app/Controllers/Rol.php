<?php

namespace App\Controllers;

use App\Models\RolModel;
use Hermawan\DataTables\DataTable;
use CodeIgniter\API\ResponseTrait;

class Rol extends BaseController
{
    use ResponseTrait;

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
                return '<button type="button" class="btn btn-primary btn-sm" onclick="obtener(\'' . $row->id . '\')"><i class="fas fa-edit"></i></button>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDeleteForm"
            onclick="borrar(\'' . $row->id . '\', \'' . $row->nombre . '\')"><i class="fa-solid fa-trash-can"></i></i></button>';
            }, 'last')
            ->toJson();
    }

    public function getAllRoles()
    {
        if ($this->request->isAJAX()) {
            $roles = $this->rolModel->findAll();
            if (!isset($roles)) {
                return $this->failNotFound('No se encontro el registro con el identificador ' . $id);
            }
            return $this->respond($roles, 200);
        }
    }

    public function saveRoles()
    {
        try {
            $form = $this->request->getPost();
            if (count($form) > 0) {

                if (!$this->validate([
                    'nombre' => "required|alpha_numeric_space|max_length[50]",
                    'descripcion' => 'required|alpha_numeric_space|max_length[100]',
                ])) {
                    configure_flash_alert('warning', 'No se pudo almacenar la informaci&oacute;n.', 'Los datos ingresados no son v&aacute;lidos.');
                    return redirect()->to('/roles');
                }
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

    public function deleteRol()
    {
        try {
            $form = $this->request->getPost();
            if (count($form) > 0) {

                if (!$this->validate([
                    'deleteId' => "required",
                ])) {
                    configure_flash_alert('warning', 'No se pudo eliminar la informaci&oacute;n.', 'Los datos ingresados no son v&aacute;lidos.');
                    return redirect()->to('/roles');
                }

                $rol = $this->rolModel->find($form['deleteId']);
                if (!isset($rol)) {
                    configure_flash_alert('warning', 'No se pudo eliminar la informaci&oacute;n.', 'No se encontr&oacute; el registro con el identificador env&iacute;ado.');
                    return redirect()->to('/roles');
                }

                if ($this->rolModel->delete($rol['id'])) {
                    configure_flash_alert('success', 'Informaci&oacute;n eliminada.', 'El registro fue eliminado exitosamente.');
                } else {
                    configure_flash_alert('warning', 'No se pudo eliminar la informaci&oacute;n.', 'El registro no pudo ser eliminado.');
                }
                return redirect()->to('/roles');
            }
        } catch (\Throwable $th) {
            configure_flash_alert('danger', 'No se pudo eliminar la informaci&oacute;n.', 'Ocurrio un error inesperado en el sistema.');
            return redirect()->to('/roles');
        }
    }
}
