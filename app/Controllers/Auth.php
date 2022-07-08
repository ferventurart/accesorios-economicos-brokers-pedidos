<?php

namespace App\Controllers;

use App\Models\RolModel;
use App\Models\UsuarioModel;
use App\Models\VerificacionCorreoModel;

class Auth extends BaseController
{
    function __construct()
    {
        $this->model = new UsuarioModel();
        $this->verificacionCorreoModel = new VerificacionCorreoModel();
        $this->rolModel = new RolModel();
    }

    public function index()
    {
        return view('login');
    }

    public function signIn()
    {
        $form = $this->request->getPost();
        if (count($form) > 0) {
            $usuario = $this->model->where('email', $form['email'])->first();
            if (!isset($usuario)) {
                configure_flash_alert('danger', 'Usuario no existe.', 'El correo electr&oacute;nico no pertenece a ningun usuario.');
                return redirect()->to('/');
            }

            $currentPassword = base64_decode($usuario['password']);
            if ($this->encrypter->decrypt($currentPassword) != $form['password']) {
                configure_flash_alert('warning', 'Contrase&ntilde;a incorrecta.', 'La contrase&ntilde;a ingresada es incorrecta.');
                return redirect()->to('/');
            }

            if ((int) $usuario['activo'] === 0) {
                configure_flash_alert('warning', 'Usuario inactivo.', 'El usuario esta inactivo, contacte al administrador.');
                return redirect()->to('/');
            }

            if ((int) $usuario['email_confirmado'] === 0) {
                configure_flash_alert('primary', 'Correo electr&oacute;nico no confirmado.', 'Confirme su correo electr&oacute;nico, revise su bandeja de entrada.');
                return redirect()->to('/');
            }

            if ((int) $usuario['requiere_cambio_password'] === 1) {
                $token = base64_encode($usuario['email']) . uniqid();
                $this->verificacionCorreoModel->save([
                    'usuario_id' => $usuario['id'],
                    'token' => $token,
                    'tipo' => EMAIL_RESET_PASSWORD,
                    'expira' => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' + 1 hours')),
                    'expirado' => 0
                ]);
                return redirect()->to('/restore-password/' . $token);
            }

            $rol = $this->rolModel->find($usuario['rol_id']);

            $this->session->set([
                'nombre' => $usuario['nombre'],
                'email'  => $usuario['email'],
                'fotografia_url' => $usuario['fotografia_url'],
                'rol' => $rol['nombre'],
                'isLoggedIn' => true
            ]);

            configure_flash_alert('success', 'Bienvenid@.', 'nuevamente <strong>' . $usuario['nombre'] . '</strong>.');
            return redirect()->to('/inicio');
        }
    }

    public function resetPassword()
    {
        return view('reset_password');
    }

    public function sendResetLink()
    {
        $email = $this->request->getPost('email');
        if (isset($email)) {
            $usuario = $this->model->where('email', $email)->first();
            if (!isset($usuario)) {
                configure_flash_alert('warning', 'Correo no fue enviado.', 'El correo electr&oacute;nico no pertenece a ningun usuario.');
                return auth_redirect();
            }

            $tokenVigente = $this->verificacionCorreoModel->where(['usuario_id' => $usuario['id'], 'tipo' => EMAIL_RESET_PASSWORD, 'expirado' => 0])->first();
            if (isset($tokenVigente) && date($tokenVigente['expira']) > date('Y-m-d H:i:s') && (int) $tokenVigente['expirado'] === 0) {
                configure_flash_alert('warning', 'Tienes un enlace vigente.', 'Revisa tu bandeja de entrada, previamente se te ha enviado el correo de restauraci&oacute;n.');
                return auth_redirect();
            }

            $token = base64_encode($usuario['email']) . uniqid();
            $this->verificacionCorreoModel->save([
                'usuario_id' => $usuario['id'],
                'token' => $token,
                'tipo' => EMAIL_RESET_PASSWORD,
                'expira' => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' + 1 hours')),
                'expirado' => 0
            ]);

            if (send_email_helper($email, 'Restablecimiento de contraseña', draw_reset_password_email_helper(base_url() . '/restore-password/' . $token))) {
                $this->session->remove(['isLoggedIn', 'nombre', 'email', 'fotografia_url']);
                configure_flash_alert('success', 'Correo enviado exitosamente.', 'Correo electr&oacute;nico de restablecimiento de contrase&ntilde;a enviado.');
                return auth_redirect();
            }
        } else {
            configure_flash_alert('danger', 'Error en el sistema.', 'Ocurrio un error generando el correo electr&oacute;nico de restauracion.');
            return redirect()->to('/reset-password');
        }
    }

    public function restorePassword($token = null)
    {
        $verificacion = $this->verificacionCorreoModel->where('token', $token)->first();
        if (!isset($verificacion)) {
            configure_flash_alert('danger', 'Enlace no valido.', 'Ocurrio un error al validar el enlace.');
            return auth_redirect();
        }
        $usuario = $this->model->find($verificacion['usuario_id']);
        if (!isset($usuario)) {
            configure_flash_alert('warning', 'Enlace no valido.', 'El correo electr&oacute;nico no pertenece a ningun usuario.');
            return auth_redirect();
        }

        return view('restore_password', ['token' => $verificacion['token'], 'email' => $usuario['email']]);
    }

    public function saveRestoredPassword($token = null)
    {
        $verificacion = $this->verificacionCorreoModel->where(['token' => $token, 'tipo' => EMAIL_RESET_PASSWORD])->first();
        if (!isset($verificacion)) {
            configure_flash_alert('danger', 'Enlace no valido.', 'Ocurrio un error al validar el enlace.');
            return auth_redirect();
        }
        $usuario = $this->model->find($verificacion['usuario_id']);
        if (!isset($usuario)) {
            configure_flash_alert('warning', 'Enlace no valido.', 'El correo electr&oacute;nico no pertenece a ningun usuario.');
            return auth_redirect();
        }

        $form = $this->request->getPost();
        if ($form['password'] != $form['confirmPassword']) {
            configure_flash_alert('warning', 'Contrase&ntilde;as  no coinciden.', 'Verifica los datos ingresados.');
            return redirect()->to('/restore-password/' . $token);
        }

        $usuario['password'] = base64_encode($this->encrypter->encrypt($form['password']));
        $verificacion['expirado'] = 1;
        
        if ($usuario['requiere_cambio_password'] === "1") {
            $usuario['requiere_cambio_password'] = 0;
        }
        if ($this->model->save($usuario) && $this->verificacionCorreoModel->save($verificacion)) {
            configure_flash_alert('success', 'Contrase&ntilde;a restaurada.', 'Su contrase&ntilde;a fue restaurada exitosamente.');
            $this->session->remove(['isLoggedIn', 'nombre', 'email', 'fotografia_url']);
            return auth_redirect();
        }

        configure_flash_alert('warning', 'Ocurrio un error.', 'No se pudo restaurar su contrase&ntilde;a.');
        return auth_redirect();
    }

    public function activateUser($token = null)
    {
        $verificacion = $this->verificacionCorreoModel->where(['token' => $token, 'tipo' => EMAIL_ACTIVATE_USER])->first();
        if (!isset($verificacion)) {
            configure_flash_alert('danger', 'Enlace no valido.', 'Ocurrio un error al validar el enlace.');
            return auth_redirect();
        }
        $usuario = $this->model->find($verificacion['usuario_id']);
        if (!isset($usuario)) {
            configure_flash_alert('warning', 'Enlace no valido.', 'El correo electr&oacute;nico no pertenece a ningun usuario.');
            return auth_redirect();
        }

        $usuario['activo'] = true;
        $usuario['email_confirmado'] = true;
        $verificacion['expirado'] = 1;
        if ($this->model->save($usuario) && $this->verificacionCorreoModel->save($verificacion)) {
            configure_flash_alert('info', 'Usuario Activado.', 'El usuario fue activado exitosamente.');
            return auth_redirect();
        }

        configure_flash_alert('warning', 'Ocurrio un error.', 'No se pudo activar el usuario.');
        return auth_redirect();
    }

    public function logout()
    {
        $this->session->remove(['isLoggedIn', 'nombre', 'email', 'fotografia_url']);
        return redirect()->to('/');
    }
}
