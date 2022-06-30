<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\DireccionEnvioModel;
use CodeIgniter\API\ResponseTrait;

class Setting extends BaseController
{
    use ResponseTrait;
    protected UsuarioModel $model;

    function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->direccionEnvioModel = new DireccionEnvioModel();
    }

    public function profile()
    {
        $usuario = $this->usuarioModel->where('email', $this->session->get('email'))->first();
        $direccionEnvio = $this->direccionEnvioModel->where('usuario_id', $usuario['id'])->first();
        return view(
            'settings/profile',
            [
                'title' => 'Mi Perfil',
                'usuario' => $usuario,
                'direccionEnvio' => $direccionEnvio,
                'departamentos' => get_departamentos_sv()
            ]
        );
    }

    public function changePassword()
    {
        $form = $this->request->getPost();
        if (count($form) > 0) {
            $usuario = $this->usuarioModel->where('email', $this->session->get('email'))->first();
            $currentPassword = base64_decode($usuario['password']);
            if ($this->encrypter->decrypt($currentPassword) != $form['currentPassword']) {
                $this->session->setFlashdata('password_tab_active', true);
                configure_flash_alert('warning', 'Contrase&ntilde;a actual no valida.', 'Por favor ingrese la contrase&ntilde;a correctamente.');
                return redirect()->to('/mi-perfil');
            }
            if ($form['password'] != $form['confirmPassword']) {
                $this->session->setFlashdata('password_tab_active', true);
                configure_flash_alert('warning', 'Contrase&ntilde;as  no coinciden.', 'Verifica los datos ingresados.');
                return redirect()->to('/mi-perfil');
            }
            $usuario['password'] = base64_encode($this->encrypter->encrypt($form['password']));
            if ($this->usuarioModel->save($usuario)) {
                configure_flash_alert('success', 'Contrase&ntilde;a cambiada.', 'Su contrase&ntilde;a fue cambiada exitosamente.');
                return redirect()->to('/mi-perfil');
            }
        }
    }

    public function updateProfile()
    {
        $form = $this->request->getPost();
        if (count($form) > 0) {
            $usuario = $this->usuarioModel->where('email', $this->session->get('email'))->first();
            $usuario['email'] = $form['email'];
            $usuario['telefono'] = $form['telefono'];
            $usuario['nombre'] = $form['nombre'];

            if ($this->usuarioModel->save($usuario)) {
                $this->session->set('nombre', $form['nombre']);
                configure_flash_alert('success', 'Informaci&oacute;n actualizada.', 'Su informaci&oacute;n fue actualizada exitosamente.');
                return redirect()->to('/mi-perfil');
            }
        }
    }

    public function getMunicipios($departamento)
    {
        if ($this->request->isAJAX()) {
            return $this->respond(get_municipios_por_departamento_sv($departamento), 200);
        }
    }

    public function updateDeliveryAddress()
    {
        $form = $this->request->getPost();
        if (count($form) > 0) {
            $usuario = $this->usuarioModel->where('email', $this->session->get('email'))->first();
            $data = [
                'usuario_id' => $usuario['id'],
                'nombre' => $form['nombre'],
                'apellido' => $form['apellido'],
                'email' => $form['email'],
                'direccion' => $form['direccion'],
                'direccion_2' => $form['direccion_2'],
                'departamento' => $form['departamento'],
                'municipio' => $form['municipio']
            ];
            $direccionEnvio = $this->direccionEnvioModel->where('usuario_id', $usuario['id'])->first();
            if (isset($direccionEnvio)) {
                $data['id'] = $direccionEnvio['id'];
            }

            if ($this->direccionEnvioModel->save($data)) {
                configure_flash_alert('success', 'Informaci&oacute;n actualizada.', 'Su informaci&oacute;n de env&iacute;o fue actualizada exitosamente.');
                return redirect()->to('/mi-perfil');
            }
        }
    }
}
