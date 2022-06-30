<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>

<?php
$session = \Config\Services::session();
if ($session->getFlashdata('password_tab_active')) {
    $passwordTab = "show active";
    $cuentaTab = "";
} else {
    $passwordTab = "";
    $cuentaTab = "show active";
}
?>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Mi Perfil</h1>
        <?= show_flash_alert() ?>
        <div class="row">
            <div class="col-md-3 col-xl-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Ajustes</h5>
                    </div>
                    <div class="list-group list-group-flush" role="tablist">
                        <a class="list-group-item list-group-item-action <?= $cuentaTab; ?>" data-bs-toggle="list" href="#account" role="tab">
                            Cuenta
                        </a>
                        <a class="list-group-item list-group-item-action <?= $passwordTab; ?>" data-bs-toggle="list" href="#password" role="tab">
                            Contrase&ntilde;a
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-9 col-xl-10">
                <div class="tab-content">
                    <div class="tab-pane fade <?= $cuentaTab; ?>" id="account" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Informaci&oacute;n de Usuario</h5>
                            </div>
                            <div class="card-body">
                                <form id="updateForm" method="POST" action="<?= base_url('update-profile') ?>">
                                    <?= csrf_field() ?>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label class="form-label" for="nombre">Nombre</label>
                                                <input type="text" class="form-control" name="nombre" placeholder="Ingrese su nombre" value="<?= $usuario['nombre']; ?>" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="email">Correo </label>
                                                <input class="form-control" type="email" name="email" placeholder="Ingrese su correo electr&oacute;nico" value="<?= $usuario['email']; ?>" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="telefono">Telefono</label>
                                                <input type="text" class="form-control" name="telefono" placeholder="Ingrese su telefono" value="<?= $usuario['telefono']; ?>" data-inputmask-mask="9999-9999" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="text-center">
                                                <img alt="Charles Hall" src="img/avatars/avatar.jpg" class="rounded-circle img-responsive mt-2" width="128" height="128" />
                                                <div class="mt-2">
                                                    <span class="btn btn-primary"><i class="fas fa-upload"></i> Subir</span>
                                                </div>
                                                <small>Para mejores resultados, usa una imagen al menos 128px por 128px en fotmato .jpg</small>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Informaci&oacute;n de Env&iacute;o</h5>
                            </div>
                            <div class="card-body">
                                <form id="deliveryForm" method="POST" action="<?= base_url('update-delivery-address') ?>">
                                    <?= csrf_field() ?>
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" for="nombre">Nombre</label>
                                            <input type="text" class="form-control" name="nombre" placeholder="Ingrese su nombre" <?= isset($direccionEnvio) ? 'value="' . $direccionEnvio['nombre'] . '"' : "" ?> />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" for="apellido">Apellido</label>
                                            <input type="text" class="form-control" name="apellido" placeholder="Ingrese su apellido" <?= isset($direccionEnvio) ? 'value="' . $direccionEnvio['apellido'] . '"' : "" ?>>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Correo Electr&oacute;nico</label>
                                        <input class="form-control" type="email" name="email" placeholder="Ingrese su correo electr&oacute;nico" <?= isset($direccionEnvio) ? 'value="' . $direccionEnvio['email'] . '"' : "" ?> />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="direccion">Direccion</label>
                                        <input type="text" class="form-control" name="direccion" placeholder="Ingrese la direccion donde sea recibir sus pedidos" <?= isset($direccionEnvio) ? 'value="' . $direccionEnvio['direccion'] . '"' : "" ?>>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="direccion_2">Direccion 2</label>
                                        <input type="text" class="form-control" name="direccion_2" placeholder="Colonia, Numero de Casa, Pasaje" <?= isset($direccionEnvio) ? 'value="' . $direccionEnvio['direccion_2'] . '"' : "" ?>>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" for="departamento">Departamento</label>
                                            <select class="form-control choices-single" id="departamento" name="departamento">
                                                <option></option>
                                                <?php foreach ($departamentos as $key => $value) {
                                                    if (isset($direccionEnvio) && $key === $direccionEnvio['departamento']) {
                                                ?>
                                                        <option selected value="<?= $key; ?>"><?= $value; ?></option>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <option value="<?= $key; ?>"><?= $value; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" for="municipio">Municipio</label>
                                            <select class="form-control choices-single" id="municipio" name="municipio">
                                                <option></option>
                                                <?php if (isset($direccionEnvio)) {
                                                ?>
                                                    <option selected value="<?= $direccionEnvio['municipio']; ?>"><?= $direccionEnvio['municipio']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade <?= $passwordTab; ?>" id="password" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Contrase&ntilde;a</h5>
                                <form id="changePasswordForm" method="POST" action="<?= base_url('change-password') ?>">
                                    <?= csrf_field() ?>
                                    <div class="mb-3">
                                        <label class="form-label" for="inputPasswordCurrent">Contrase&ntilde;a actual</label>
                                        <input type="password" class="form-control" name="currentPassword" autocomplete>
                                        <a href="<?= base_url('reset-password') ?>">¿Ha olvidado su contrase&ntilde;a?</a>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="inputPasswordNew">Nueva Contrase&ntilde;a</label>
                                        <input type="password" class="form-control" name="password" autocomplete>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="inputPasswordNew2">Confirmar Contrase&ntilde;a</label>
                                        <input type="password" class="form-control" name="confirmPassword" autocomplete>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.35.3/es6-shim.min.js"></script>
<script src="<?= base_url('js/formvalidation/dist/js/FormValidation.min.js') ?>"></script>
<script src="<?= base_url('js/formvalidation/dist/js/plugins/Bootstrap5.js') ?>"></script>
<script src="<?= base_url('js/formvalidation/dist/js/locales/es_ES.min.js') ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', function(e) {
        const changePasswordForm = document.getElementById('changePasswordForm');
        const submitChangePasswordButton = changePasswordForm.querySelector('button[type="submit"]');
        const fvChangePasswordForm = FormValidation.formValidation(changePasswordForm, {
            locale: 'es_ES',
            localization: FormValidation.locales.es_ES,
            fields: {
                currentPassword: {
                    validators: {
                        notEmpty: {},
                        stringLength: {
                            min: 8
                        },
                    },
                },
                password: {
                    validators: {
                        notEmpty: {},
                        stringLength: {
                            min: 8
                        },
                    },
                },
                confirmPassword: {
                    validators: {
                        notEmpty: {},
                        stringLength: {
                            min: 8
                        },
                        identical: {
                            compare: function() {
                                return changePasswordForm.querySelector('[name="password"]').value;
                            },
                        },
                    },
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.mb-3',
                }),
                submitButton: new FormValidation.plugins.SubmitButton(),
                icon: new FormValidation.plugins.Icon({
                    valid: 'fa fa-check',
                    invalid: 'fa fa-times',
                    validating: 'fa fa-refresh',
                }),
                defaultSubmit: new FormValidation.plugins.DefaultSubmit()
            },
        }).on('core.form.valid', function() {
            // Disable the submit button
            submitChangePasswordButton.setAttribute('disabled', true);

            submitChangePasswordButton.innerHTML = 'Guardando...';
        });
        // Revalidate the confirmation password when changing the password
        changePasswordForm.querySelector('[name="password"]').addEventListener('input', function() {
            fvChangePasswordForm.revalidateField('confirmPassword');
        });
    });
</script>
<script>
    const updateForm = document.getElementById('updateForm');
    const submitUpdateFormButton = updateForm.querySelector('button[type="submit"]');
    FormValidation.formValidation(updateForm, {
        locale: 'es_ES',
        localization: FormValidation.locales.es_ES,
        fields: {
            email: {
                validators: {
                    notEmpty: {},
                    emailAddress: {},
                },
            },
            nombre: {
                validators: {
                    notEmpty: {},
                    stringLength: {
                        min: 8
                    },
                },
            },
            telefono: {
                validators: {
                    notEmpty: {},
                    stringLength: {
                        max: 9
                    }
                },
            },
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                rowSelector: '.mb-3',
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            icon: new FormValidation.plugins.Icon({
                valid: 'fa fa-check',
                invalid: 'fa fa-times',
                validating: 'fa fa-refresh',
            }),
            defaultSubmit: new FormValidation.plugins.DefaultSubmit()
        },
    }).on('core.form.valid', function() {
        // Disable the submit button
        submitUpdateFormButton.setAttribute('disabled', true);

        submitUpdateFormButton.innerHTML = 'Guardando...';
    });
</script>
<script>
    var municipio = new Choices(document.getElementById('municipio'));
    var departamento = new Choices(document.getElementById('departamento'));
    departamento.passedElement.element.addEventListener('change', function(event) {
        fetch(`<?= base_url('municipios') ?>/${event.detail.value}`, {
            method: "get",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            }
        }).then(response => {
            return response.json()
        }).then((municipios) => {
            municipio.clearChoices();
            municipio.setValue(municipios);
        });
    });
</script>
<script>
    const deliveryForm = document.getElementById('deliveryForm');
    const submitDeliveryFormButton = deliveryForm.querySelector('button[type="submit"]');
    document.addEventListener('DOMContentLoaded', function(e) {
        FormValidation.formValidation(document.getElementById('deliveryForm'), {
            locale: 'es_ES',
            localization: FormValidation.locales.es_ES,
            fields: {
                nombre: {
                    validators: {
                        notEmpty: {},
                        stringLength: {
                            min: 5,
                            max: 50
                        },
                    },
                },
                apellido: {
                    validators: {
                        notEmpty: {},
                        stringLength: {
                            min: 5,
                            max: 50
                        },
                    },
                },
                email: {
                    validators: {
                        notEmpty: {},
                        emailAddress: {},
                    },
                },
                direccion: {
                    validators: {
                        notEmpty: {},
                        stringLength: {
                            max: 120,
                            min: 8
                        }
                    },
                },
                direccion_2: {
                    validators: {
                        stringLength: {
                            max: 100,
                            min: 3
                        }
                    },
                },
                departamento: {
                    validators: {
                        notEmpty: {},
                    },
                },
                municipio: {
                    validators: {
                        notEmpty: {},
                    },
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.mb-3',
                }),
                submitButton: new FormValidation.plugins.SubmitButton(),
                icon: new FormValidation.plugins.Icon({
                    valid: 'fa fa-check',
                    invalid: 'fa fa-times',
                    validating: 'fa fa-refresh',
                }),
                defaultSubmit: new FormValidation.plugins.DefaultSubmit()
            },
        }).on('core.form.valid', function() {
            // Disable the submit button
            submitDeliveryButton.setAttribute('disabled', true);

            submitDeliveryButton.innerHTML = 'Guardando...';
        });
    });
</script>
<?= $this->endSection() ?>