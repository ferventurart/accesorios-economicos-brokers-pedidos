<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de Pedidos En Linea - Accesorios Econ&oacute;micos">
    <meta name="author" content="Oscar Fernando Ventura Ortiz">
    <meta name="keywords" content="pedidos, brokers, accesorios economicos, pedidos de accesorios, brokers de accesorios">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="<?= base_url('img/icons/logo-accesorioseconomicos-stroke-85x85.png') ?>" />
    <link rel="canonical" href="<?= current_url() ?>" />

    <title>Restaurar contrase&ntilde;a | Sistema de Pedidos</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('js/formvalidation/dist/css/formValidation.min.css') ?>" />
    <!-- Choose your prefered color scheme -->
    <link href="<?= base_url('css/light.css') ?>" rel="stylesheet">
    <!-- <link href="css/dark.css" rel="stylesheet"> -->
</head>
<!--
  HOW TO USE: 
  data-theme: default (default), dark, light, colored
  data-layout: fluid (default), boxed
  data-sidebar-position: left (default), right
  data-sidebar-layout: default (default), compact
-->

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
    <main class="d-flex w-100 h-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        <?= show_flash_alert() ?>
                        <div class="text-center mt-4">
                            <h1 class="h2">Restaurar contrase&ntilde;a</h1>
                            <p class="lead">Estimado usuario propietario del correo <strong><?=$email;?></strong>, ingrese su nueva contrase&ntilde;a.
                            </p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <form id="restoreForm" method="POST" action="<?= base_url() . '/restore-password/' . $token; ?>">
                                        <?= csrf_field() ?>
                                        <div class="mb-3">
                                            <label class="form-label">Contrase&ntilde;a</label>
                                            <input class="form-control form-control-lg" type="password" name="password" autocomplete placeholder="Ingrese su contrase&ntilde;a" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Confirme su Contrase&ntilde;a</label>
                                            <input class="form-control form-control-lg" type="password" name="confirmPassword" autocomplete placeholder="Confirme su contrase&ntilde;a" />
                                        </div>
                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-lg btn-primary">Restablecer contrase&ntilde;a</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="<?= base_url('js/app.js') ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.35.3/es6-shim.min.js"></script>
    <script src="<?= base_url('js/formvalidation/dist/js/FormValidation.min.js') ?>"></script>
    <script src="<?= base_url('js/formvalidation/dist/js/plugins/Bootstrap5.js') ?>"></script>
    <script src="<?= base_url('js/formvalidation/dist/js/locales/es_ES.min.js') ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function(e) {
            const restoreForm = document.getElementById('restoreForm');
            const submitRestoreButton = restoreForm.querySelector('button[type="submit"]');
            const fv = FormValidation.formValidation(restoreForm, {
                locale: 'es_ES',
                localization: FormValidation.locales.es_ES,
                fields: {
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
                                    return restoreForm.querySelector('[name="password"]').value;
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
                submitRestoreButton.setAttribute('disabled', true);

                submitRestoreButton.innerHTML = 'Guardando...';
            });
            // Revalidate the confirmation password when changing the password
            restoreForm.querySelector('[name="password"]').addEventListener('input', function() {
                fv.revalidateField('confirmPassword');
            });
        });
    </script>
</body>

</html>