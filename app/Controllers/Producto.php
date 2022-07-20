<?php

namespace App\Controllers;

use App\Models\CategoriaProductoModel;
use App\Models\ProductoModel;
use Hermawan\DataTables\DataTable;
use Picqer\Barcode\BarcodeGeneratorPNG;
use CodeIgniter\API\ResponseTrait;

class Producto extends BaseController
{
    use ResponseTrait;

    function __construct()
    {
        $this->categoriaProductoModel = new CategoriaProductoModel();
        $this->productoModel = new ProductoModel();
    }

    public function index()
    {
        $categoriasProducto = $this->categoriaProductoModel->where('activa', 1)->findAll();
        return view('producto/index', ['title' => 'Productos', 'categoriasProducto' => $categoriasProducto]);
    }

    public function getProductos()
    {
        $builder = $this->productoModel->select('id, sku, nombre, precio_venta, activo');
        return DataTable::of($builder)
            ->filter(function ($builder, $request) {

                if ($request->categoriaProductoSearch)
                    $builder->where('categoria_id', $request->categoriaProductoSearch);
            })->format('activo', function ($value) {
                if ($value == "1") {
                    return '<span class="badge bg-success">Activo</span>';
                } else {
                    return '<span class="badge bg-secondary">Inactivo</span>';
                }
            })->format('precio_venta', function ($value) {
                return '$' . $value . '';
            })->add('action', function ($row) {
                return '<button type="button" class="btn btn-primary btn-sm" onclick="obtener(\'' . $row->id . '\')"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDeleteForm"
                onclick="borrar(\'' . $row->id . '\', \'' . $row->nombre . '\')"><i class="fa-solid fa-trash-can"></i></i></button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="imprimirSku(\'' . $row->sku . '\')"><i class="fa-solid fa-barcode"></i></button>';
            }, 'last')
            ->toJson();
    }

    public function saveProductos()
    {
        try {
            $form = $this->request->getPost();
            if (count($form) > 0) {

                if (!$this->validate([
                    'nombre' => "required|alpha_numeric_space|max_length[100]",
                    'precio_broker' => 'required|numeric',
                    'precio_venta' => 'required|numeric',
                    'categoria_id' => 'required',
                    'descripcion' => 'permit_empty|max_length[150]',
                    'sku' => 'permit_empty|max_length[70]',
                    'codigo_barra' => 'permit_empty|max_length[100]',
                ])) {
                    configure_flash_alert('warning', 'No se pudo almacenar la informaci&oacute;n.', 'Los datos ingresados no son v&aacute;lidos.');
                    return redirect()->to('/productos');
                }

                $form = $this->handleFormCheckboxes($form);

                $validateImage = $this->validate([
                    'file' => [
                        'uploaded[file]',
                        'ext_in[file,jpg,jpeg,png]',
                        'max_size[file,1024]',
                    ],
                ]);

                if ($validateImage) {

                    $file = $this->request->getFile('file');
                    $newName = $file->getRandomName();
                    $file->move('../public/img/products',  $newName);

                    if (isset($form['id'])) {
                        $producto = $this->productoModel->find($form['id']);
                        if (isset($producto['imagen_producto'])) {
                            $fileToDelete = '../public' . str_replace(base_url(), "", $producto['imagen_producto']);
                            unlink($fileToDelete);
                        }
                        $form['imagen_producto'] = base_url() . "/img/products/" . $newName;
                    }
                }

                if ($this->productoModel->save($form)) {
                    if ($form['id'] === "0") {
                        $producto = $this->productoModel->where('nombre', $form['nombre'])->first();
                        $categoria = $this->categoriaProductoModel->find($producto['categoria_id']);
                        $producto['sku'] = sku_generator($producto['nombre'], $categoria['nombre'], $producto['id']);
                        $this->productoModel->save($producto);
                    }
                    configure_flash_alert('success', 'Informaci&oacute;n almacenada.', 'El registro fue guardado exitosamente.');
                } else {
                    configure_flash_alert('warning', 'No se pudo almacenar la informaci&oacute;n.', 'El registro no pudo ser guardado.');
                }
                return redirect()->to('/productos');
            }
        } catch (\Throwable $th) {
            configure_flash_alert('danger', 'No se pudo almacenar la informaci&oacute;n.', 'Ocurrio un error inesperado en el sistema.');
            return redirect()->to('/productos');
        }
    }

    public function getProducto($id)
    {
        if ($this->request->isAJAX()) {
            if (!isset($id)) {
                return $this->fail('Falto pasar el valor del identificador.', 400);
            }
            $producto = $this->productoModel->find($id);
            if (!isset($producto)) {
                return $this->failNotFound('No se encontro el registro con el identificador ' . $id);
            }
            return $this->respond($producto, 200);
        }
    }

    public function deleteProducto()
    {
        try {
            $form = $this->request->getPost();
            if (count($form) > 0) {

                if (!$this->validate([
                    'deleteId' => "required",
                ])) {
                    configure_flash_alert('warning', 'No se pudo eliminar la informaci&oacute;n.', 'Los datos ingresados no son v&aacute;lidos.');
                    return redirect()->to('/productos');
                }

                $producto = $this->productoModel->find($form['deleteId']);
                if (!isset($producto)) {
                    configure_flash_alert('warning', 'No se pudo eliminar la informaci&oacute;n.', 'No se encontr&oacute; el registro con el identificador env&iacute;ado.');
                    return redirect()->to('/productos');
                }

                if ($this->productoModel->delete($producto['id'])) {
                    if (isset($producto['imagen_producto'])) {
                        $fileToDelete = '../public' . str_replace(base_url(), "", $producto['imagen_producto']);
                        unlink($fileToDelete);
                    }
                    configure_flash_alert('success', 'Informaci&oacute;n eliminada.', 'El registro fue eliminado exitosamente.');
                } else {
                    configure_flash_alert('warning', 'No se pudo eliminar la informaci&oacute;n.', 'El registro no pudo ser eliminado.');
                }
                return redirect()->to('/productos');
            }
        } catch (\Throwable $th) {
            configure_flash_alert('danger', 'No se pudo eliminar la informaci&oacute;n.', 'Ocurrio un error inesperado en el sistema.');
            return redirect()->to('/productos');
        }
    }

    public function generateSkuPrintable($sku)
    {
        $htmlCodeBar = sku_html_printer($sku);
        $producto = $this->productoModel->where('sku', $sku)->first();
        if (!isset($producto)) {
            configure_flash_alert('warning', 'No se pudo imprimir la informaci&oacute;n.', 'No se encontr&oacute; el registro con el identificador env&iacute;ado.');
            return redirect()->to('/productos');
        }
        return view('producto/print_sku', ['title' => 'Imprimir SKU ' . $sku, 'codeBar' => $htmlCodeBar, 'producto' => $producto]);
    }
    private function handleFormCheckboxes($form)
    {
        if (!isset($form['activo'])) {
            $form['activo'] = "0";
        }
        return $form;
    }
}
