<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoriaProductoModel;
use Hermawan\DataTables\DataTable;
use CodeIgniter\API\ResponseTrait;

class CategoriaProducto extends BaseController
{
    use ResponseTrait;

    function __construct()
    {
        $this->categoriaProductoModel = new CategoriaProductoModel();
    }

    public function index()
    {
        return view('categoria_producto/index', ['title' => 'Categorias de Producto']);
    }

    public function getCategoriasProducto()
    {
        $builder = $this->categoriaProductoModel->select('id, nombre, activa');
        return DataTable::of($builder)
            ->format('activa', function ($value) {
                if ($value == "1") {
                    return '<span class="badge bg-success">Activa</span>';
                } else {
                    return '<span class="badge bg-secondary">Inactiva</span>';
                }
            })
            ->add('action', function ($row) {
                return '<button type="button" class="btn btn-primary btn-sm" onclick="obtener(\'' . $row->id . '\')"><i class="fas fa-edit"></i></button>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDeleteForm"
            onclick="borrar(\'' . $row->id . '\', \'' . $row->nombre . '\')"><i class="fa-solid fa-trash-can"></i></i></button>';
            }, 'last')
            ->toJson();
    }

    public function saveCategoriasProducto()
    {
        try {
            $form = $this->request->getPost();
            if (count($form) > 0) {

                if (!$this->validate([
                    'nombre' => "required|alpha_numeric_space|max_length[75]",
                ])) {
                    configure_flash_alert('warning', 'No se pudo almacenar la informaci&oacute;n.', 'Los datos ingresados no son v&aacute;lidos.');
                    return redirect()->to('/categoriasProducto');
                }
                $form = $this->handleFormCheckboxes($form);
                if ($this->categoriaProductoModel->save($form)) {
                    configure_flash_alert('success', 'Informaci&oacute;n almacenada.', 'El registro fue guardado exitosamente.');
                } else {
                    configure_flash_alert('warning', 'No se pudo almacenar la informaci&oacute;n.', 'El registro no pudo ser guardado.');
                }
                return redirect()->to('/categoriasProducto');
            }
        } catch (\Throwable $th) {
            configure_flash_alert('danger', 'No se pudo almacenar la informaci&oacute;n.', 'Ocurrio un error inesperado en el sistema.');
            return redirect()->to('/categoriasProducto');
        }
    }

    public function getCategoriaProducto($id)
    {
        if ($this->request->isAJAX()) {
            if (!isset($id)) {
                return $this->fail('Falto pasar el valor del identificador.', 400);
            }
            $categoria = $this->categoriaProductoModel->find($id);
            if (!isset($categoria)) {
                return $this->failNotFound('No se encontro el registro con el identificador ' . $id);
            }
            return $this->respond($categoria, 200);
        }
    }

    public function deleteCategoriaProducto()
    {
        try {
            $form = $this->request->getPost();
            if (count($form) > 0) {

                if (!$this->validate([
                    'deleteId' => "required",
                ])) {
                    configure_flash_alert('warning', 'No se pudo eliminar la informaci&oacute;n.', 'Los datos ingresados no son v&aacute;lidos.');
                    return redirect()->to('/categoriasProducto');
                }

                $categoria = $this->categoriaProductoModel->find($form['deleteId']);
                if (!isset($categoria)) {
                    configure_flash_alert('warning', 'No se pudo eliminar la informaci&oacute;n.', 'No se encontr&oacute; el registro con el identificador env&iacute;ado.');
                    return redirect()->to('/categoriasProducto');
                }

                if ($this->categoriaProductoModel->delete($categoria['id'])) {
                    configure_flash_alert('success', 'Informaci&oacute;n eliminada.', 'El registro fue eliminado exitosamente.');
                } else {
                    configure_flash_alert('warning', 'No se pudo eliminar la informaci&oacute;n.', 'El registro no pudo ser eliminado.');
                }
                return redirect()->to('/categoriasProducto');
            }
        } catch (\Throwable $th) {
            configure_flash_alert('danger', 'No se pudo eliminar la informaci&oacute;n.', 'Ocurrio un error inesperado en el sistema.');
            return redirect()->to('/categoriasProducto');
        }
    }

    private function handleFormCheckboxes($form)
    {
        if (!isset($form['activa'])) {
            $form['activa'] = "0";
        }
        return $form;
    }
}
