<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RolModel;
use App\Models\UsuarioModel;
use App\Models\VerificacionCorreoModel;
use Hermawan\DataTables\DataTable;
use CodeIgniter\API\ResponseTrait;

class Usuario extends BaseController
{
    use ResponseTrait;

    function __construct()
    {
        $this->rolModel = new RolModel();
        $this->usuarioModel = new UsuarioModel();
        $this->verificacionCorreoModel = new VerificacionCorreoModel();
    }

    public function index()
    {
        $roles = $this->rolModel->findAll();
        return view('usuario/index', ['title' => 'Usuarios del Sistema', 'roles' => $roles]);
    }

    public function getUsuarios()
    {
        $builder = $this->usuarioModel->select('id, nombre, email, telefono, activo, email_confirmado');
        return DataTable::of($builder)
            ->filter(function ($builder, $request) {

                if ($request->rolSearch)
                    $builder->where('rol_id', $request->rolSearch);
            })->format('activo', function ($value) {
                if ($value == "1") {
                    return '<span class="badge bg-success">Activo</span>';
                } else {
                    return '<span class="badge bg-secondary">Inactivo</span>';
                }
            })->format('email_confirmado', function ($value) {
                if ($value == "1") {
                    return '<i class="fa-solid fa-2x fa-check text-success"></i>';
                } else {
                    return '<i class="fa-solid fa-2x fa-triangle-exclamation text-warning"></i>';
                }
            })
            ->add('action', function ($row) {
                return '<button type="button" class="btn btn-primary btn-sm" onclick="obtener(\'' . $row->id . '\')"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDeleteForm"
                onclick="borrar(\'' . $row->id . '\', \'' . $row->nombre . '\')"><i class="fa-solid fa-trash-can"></i></i></button>';
            }, 'last')
            ->toJson();
    }

    public function saveUsuarios()
    {
        try {
            $form = $this->request->getPost();
            if (count($form) > 0) {

                if (!$this->validate([
                    'nombre' => "required|alpha_numeric_space|max_length[100]",
                    'email' => 'required|valid_email|max_length[120]',
                    'rol_id' => 'required',
                    'telefono' => 'required|max_length[9]',
                ])) {
                    configure_flash_alert('warning', 'No se pudo almacenar la informaci&oacute;n.', 'Los datos ingresados no son v&aacute;lidos.');
                    return redirect()->to('/usuarios');
                }

                $esNuevoUsuario = $this->isNewUser($form['id']);

                if ($esNuevoUsuario) {
                    $plainPassword = get_random_password();
                    $form['password'] = base64_encode($this->encrypter->encrypt($plainPassword));
                    $form['fotografia_url'] = base_url() . "/img/avatars/user.png";
                }

                $form = $this->handleFormCheckboxes($form);

                if ($this->usuarioModel->save($form)) {
                    $usuario = $this->usuarioModel->where('email', $form['email'])->first();
                    if ($esNuevoUsuario) {
                        $token = base64_encode($usuario['email']) . uniqid();
                        $this->verificacionCorreoModel->save([
                            'usuario_id' => $usuario['id'],
                            'token' => $token,
                            'tipo' => EMAIL_ACTIVATE_USER,
                            'expira' => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' + 1 hours')),
                            'expirado' => 0
                        ]);
                        if (
                            send_email_helper($form['email'], 'Activacion de usuario', draw_activation_user_email_helper(base_url() . '/activate-user/' . $token))
                            && send_email_helper($form['email'], 'Contraseña temporal', draw_temporal_password_email_helper($form['email'], $plainPassword))
                        ) {
                            configure_flash_alert('success', 'Usuario registrado exitosamente.', 'Se env&iacute;o un correo electr&oacute;nico al usuario para su activaci&oacute;n.');
                            return redirect()->to('/usuarios');
                        }
                    } else {
                        configure_flash_alert('success', 'Informaci&oacute;n almacenada.', 'El registro fue guardado exitosamente.');
                    }
                } else {
                    configure_flash_alert('warning', 'No se pudo almacenar la informaci&oacute;n.', 'El registro no pudo ser guardado.');
                }
                return redirect()->to('/usuarios');
            }
        } catch (\Throwable $th) {
            configure_flash_alert('danger', 'No se pudo almacenar la informaci&oacute;n.', 'Ocurrio un error inesperado en el sistema.');
            return redirect()->to('/usuarios');
        }
    }

    public function getUsuario($id)
    {
        if ($this->request->isAJAX()) {
            if (!isset($id)) {
                return $this->fail('Falto pasar el valor del identificador.', 400);
            }
            $usuario = $this->usuarioModel->select('id, nombre, email, rol_id, activo, email_confirmado, telefono, fotografia_url, requiere_cambio_password, mfa_habilitado')->first();
            if (!isset($usuario)) {
                return $this->failNotFound('No se encontro el registro con el identificador ' . $id);
            }
            return $this->respond($usuario, 200);
        }
    }

    public function deleteUsuario()
    {
        try {
            $form = $this->request->getPost();
            if (count($form) > 0) {

                if (!$this->validate([
                    'deleteId' => "required",
                ])) {
                    configure_flash_alert('warning', 'No se pudo eliminar la informaci&oacute;n.', 'Los datos ingresados no son v&aacute;lidos.');
                    return redirect()->to('/usuarios');
                }

                $usuario = $this->usuarioModel->find($form['deleteId']);
                if (!isset($usuario)) {
                    configure_flash_alert('warning', 'No se pudo eliminar la informaci&oacute;n.', 'No se encontr&oacute; el registro con el identificador env&iacute;ado.');
                    return redirect()->to('/usuarios');
                }

                if ($this->usuarioModel->delete($usuario['id'])) {
                    configure_flash_alert('success', 'Informaci&oacute;n eliminada.', 'El registro fue eliminado exitosamente.');
                } else {
                    configure_flash_alert('warning', 'No se pudo eliminar la informaci&oacute;n.', 'El registro no pudo ser eliminado.');
                }
                return redirect()->to('/usuarios');
            }
        } catch (\Throwable $th) {
            configure_flash_alert('danger', 'No se pudo eliminar la informaci&oacute;n.', 'Ocurrio un error inesperado en el sistema.');
            return redirect()->to('/usuarios');
        }
    }

    private function isNewUser($id)
    {
        return $id === "0" ? true : false;
    }

    private function handleFormCheckboxes($form)
    {
        if (!isset($form['activo'])) {
            $form['activo'] = "0";
        }
        if (!isset($form['requiere_cambio_password'])) {
            $form['requiere_cambio_password'] = "0";
        }
        if (!isset($form['mfa_habilitado'])) {
            $form['mfa_habilitado'] = "0";
        }
        return $form;
    }
}
