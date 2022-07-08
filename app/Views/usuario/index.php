<?= $this->extend('template/admin') ?>
<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.1.0/dist/css/tom-select.bootstrap5.min.css">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<main class="content">
    <div class="container-fluid p-0">
        <?= show_flash_alert() ?>
        <button type="button" class="btn btn-primary float-end mt-n1" data-bs-toggle="modal" data-bs-target="#modalDataForm">
            <i class="fas fa-plus"></i> Nuevo Registro</a>
        </button>
        <h1 class="h3 mb-3"><?= $title; ?></h1>
        <div class="row">
            <div class="col-xl-6">
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="rolSearch"><i class="fa-solid fa-filter"></i>&nbsp;Filtrar por Rol</label>
                    <select class="form-select" id="rolSearch" name="rolSearch">
                        <option value="">Seleccione una opci&oacute;n</option>
                        <?php foreach ($roles as $value) {
                        ?>
                            <option value="<?= $value['id']; ?>"><?= $value['nombre']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Listado de <?= $title; ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <div id="loader" style="display: none; width: 3rem; height: 3rem;" class="spinner-border text-primary me-2" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                        </div>
                        <div class="table-responsive" id="mainRow">
                            <table id="table" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Telefono</th>
                                        <th>Estado</th>
                                        <th>Confirmado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalDataForm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Formulario de <?= $title; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body m-3">
                        <form id="dataForm" method="POST" action="<?= base_url('usuarios') ?>">
                            <?= csrf_field() ?>
                            <input class="form-control" type="hidden" id="id" name="id" value="0" />
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre del usuario" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Correo Electr&oacute;nico</label>
                                <input class="form-control" type="email" id="email" name="email" placeholder="Ingrese su correo electr&oacute;nico" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Rol de Usuario</label>
                                <select class="form-select" id="rol_id" name="rol_id">
                                    <option value="">Seleccione una opci&oacute;n</option>
                                    <?php foreach ($roles as $value) {
                                    ?>
                                        <option value="<?= $value['id']; ?>"><?= $value['nombre']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="telefono">Telefono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingrese su telefono" data-inputmask-mask="9999-9999" />
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="requiere_cambio_password" name="requiere_cambio_password" value="1" checked>
                                    <label class="form-check-label" for="requiere_cambio_password">Requiere Cambio de Password</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="mfa_habilitado" name="mfa_habilitado" value="1">
                                    <label class="form-check-label" for="mfa_habilitado">Multifactor de Autenticacion</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="email_confirmado" disabled>
                                    <label class="form-check-label" for="activo">Email Confirmado</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="activo" name="activo" value="1" disabled>
                                    <label class="form-check-label" for="activo">Activo</label>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-lg btn-secondary"><i class="fa-solid fa-eraser"></i> Limpiar</button>
                        <button type="submit" id="btnSave" class="btn btn-lg btn-success"><i class="fas fa-save"></i> Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END modalDataForm modal -->
        <div class="modal fade" id="modalDeleteForm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white">Eliminar Registro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body m-3">
                        <form id="deleteForm" method="POST" action="<?= base_url('delete-usuario') ?>">
                            <?= csrf_field() ?>
                            <input class="form-control" type="hidden" id="deleteId" name="deleteId" value="0" />
                            <p id="deleteMessage">¿Esta seguro de eliminar el registro seleccionado?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submmit" class="btn btn btn-danger"><i class="fa-solid fa-trash-can"></i></i>&nbsp;Si, eliminarlo.</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END  modal -->
    </div>
</main>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.35.3/es6-shim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.1.0/dist/js/tom-select.complete.min.js"></script>
<script src="<?= base_url('js/formvalidation/dist/js/FormValidation.min.js') ?>"></script>
<script src="<?= base_url('js/formvalidation/dist/js/plugins/Bootstrap5.js') ?>"></script>
<script src="<?= base_url('js/formvalidation/dist/js/locales/es_ES.min.js') ?>"></script>
<script src="<?= base_url('js/datatables.js') ?>"></script>
<script>
    $(document).ready(function() {
        new TomSelect("#rolSearch", {
            allowEmptyOption: false,
            create: false,
            maxItems: 1,
            plugins: ['clear_button', 'dropdown_input'],
            persist: false,
            render: {
                no_results: function(data, escape) {
                    return '<div class="no-results"><i class="fa-solid fa-magnifying-glass"></i> No hay resultados para "' + escape(data.input) + '"</div>';
                },
            }
        });

        table = $('#table').DataTable({
            responsive: true,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json"
            },
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: "<?= base_url('get-usuarios') ?>",
                data: function(d) {
                    d.rolSearch = $('#rolSearch').val();
                }
            },
            columnDefs: [{
                targets: [3, 4, 5, -1],
                orderable: false,
                className: 'text-center'
            }]
        });

        $('#rolSearch').change(function(event) {
            table.ajax.reload();
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function(e) {
        var dataForm = document.getElementById('dataForm');
        const submitDataFormButton = document.getElementById('btnSave');
        const fv = FormValidation.formValidation(dataForm, {
            locale: 'es_ES',
            localization: FormValidation.locales.es_ES,
            fields: {
                nombre: {
                    validators: {
                        notEmpty: {},
                        stringLength: {
                            min: 5,
                            max: 100
                        },
                    },
                },
                email: {
                    validators: {
                        notEmpty: {},
                        emailAddress: {},
                        stringLength: {
                            min: 8,
                            max: 100
                        },
                    },
                },
                rol_id: {
                    validators: {
                        notEmpty: {},
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
            submitDataFormButton.setAttribute('disabled', true);

            submitDataFormButton.innerHTML = 'Guardando...';
        });
        dataForm.onreset = function() {
            document.getElementById('id').value = "";
            document.getElementById("activo").disabled = true;
            fv.resetForm();
        };
        document.getElementById('modalDataForm').addEventListener('hide.bs.modal', function(event) {
            dataForm.reset();
        });
    });
</script>
<script>
    const rolIdSelect = new TomSelect("#rol_id", {
        allowEmptyOption: false,
        create: false,
        maxItems: 1,
        plugins: ['clear_button', 'dropdown_input'],
        persist: false,
        render: {
            no_results: function(data, escape) {
                return '<div class="no-results"><i class="fa-solid fa-magnifying-glass"></i> No hay resultados para "' + escape(data.input) + '"</div>';
            },
        }
    });

    var modalDataForm = new bootstrap.Modal(document.getElementById('modalDataForm'), {});
    const obtener = (id) => {
        document.getElementById('mainRow').style.display = "none";
        document.getElementById('loader').style.display = "block";
        fetch(`<?= base_url('get-usuario') ?>/${id}`, {
            method: "get",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            }
        }).then(response => {
            return response.json()
        }).then((usuario) => {
            console.log(usuario);
            document.getElementById('id').value = usuario.id;
            document.getElementById('nombre').value = usuario.nombre;
            document.getElementById('email').value = usuario.email;
            document.getElementById('telefono').value = usuario.telefono;
            rolIdSelect.setValue(usuario.rol_id);
            document.getElementById("requiere_cambio_password").checked = usuario.requiere_cambio_password == "1" ? true : false;
            document.getElementById("mfa_habilitado").checked = usuario.mfa_habilitado == "1" ? true : false;
            document.getElementById("email_confirmado").checked = usuario.email_confirmado == "1" ? true : false;
            document.getElementById("activo").checked = usuario.activo == "1" ? true : false;
            document.getElementById("activo").disabled = false;

            modalDataForm.show();
            document.getElementById('mainRow').style.display = "block";
            document.getElementById('loader').style.display = "none";
        });
    }
</script>
<script>
    var deleteForm = document.getElementById('deleteForm');
    deleteForm.onreset = function() {
        document.getElementById('deleteId').value = "";
    };
    var modalDeleteForm = new bootstrap.Modal(document.getElementById('modalDeleteForm'), {});
    document.getElementById('modalDeleteForm').addEventListener('hide.bs.modal', function(event) {
        deleteForm.reset();
    });
    const borrar = (id, nombre) => {
        document.getElementById('deleteId').value = id;
        document.getElementById('deleteMessage').innerHTML = `¿Esta seguro de eliminar el registro: <strong>${nombre}</strong>?`;
    }
</script>
<?= $this->endSection() ?>