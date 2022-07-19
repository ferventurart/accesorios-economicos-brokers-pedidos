<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<main class="content">
    <div class="container-fluid p-0">
        <?= show_flash_alert() ?>
        <button type="button" class="btn btn-primary float-end mt-n1" data-bs-toggle="modal" data-bs-target="#modalDataForm">
            <i class="fas fa-plus"></i> Nuevo Registro</a>
        </button>
        <h1 class="h3 mb-3"><?= $title; ?></h1>
        <div class="row">
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
                                        <th>Descripcion</th>
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
                        <form id="dataForm" method="POST" action="<?= base_url('roles') ?>">
                            <?= csrf_field() ?>
                            <input class="form-control form-control-lg" type="hidden" id="id" name="id" value="0" />
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input class="form-control form-control-lg" type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre del rol" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descripcion</label>
                                <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Ingrese la descripcion del rol" rows="3"></textarea>
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
                        <form id="deleteForm" method="POST" action="<?= base_url('delete-rol') ?>">
                            <?= csrf_field() ?>
                            <input class="form-control form-control-lg" type="hidden" id="deleteId" name="deleteId" value="0" />
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
<script src="<?= base_url('js/formvalidation/dist/js/FormValidation.min.js') ?>"></script>
<script src="<?= base_url('js/formvalidation/dist/js/plugins/Bootstrap5.js') ?>"></script>
<script src="<?= base_url('js/formvalidation/dist/js/locales/es_ES.min.js') ?>"></script>
<script src="<?= base_url('js/datatables.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('.sidebar-roles').addClass('active');
        $('#table').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json"
            },
            processing: true,
            serverSide: true,
            order: [],
            ajax: "<?= base_url('get-roles') ?>",
            columnDefs: [{
                targets: -1,
                orderable: false,
                className: 'text-center'
            }, ]
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
                            max: 50
                        },
                    },
                },
                descripcion: {
                    validators: {
                        notEmpty: {},
                        stringLength: {
                            min: 8,
                            max: 100
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
            submitDataFormButton.setAttribute('disabled', true);

            submitDataFormButton.innerHTML = 'Guardando...';
        });
        dataForm.onreset = function() {
            document.getElementById('id').value = "";
            fv.resetForm();
        };
    });
</script>
<script>
    var modalDataForm = new bootstrap.Modal(document.getElementById('modalDataForm'), {});
    document.getElementById('modalDataForm').addEventListener('hide.bs.modal', function(event) {
        dataForm.reset();
    });
    const obtener = (id) => {
        document.getElementById('mainRow').style.display = "none";
        document.getElementById('loader').style.display = "block";
        fetch(`<?= base_url('get-rol') ?>/${id}`, {
            method: "get",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            }
        }).then(response => {
            return response.json()
        }).then((rol) => {
            dataForm.reset();
            document.getElementById('id').value = rol.id;
            document.getElementById('nombre').value = rol.nombre;
            document.getElementById('descripcion').value = rol.descripcion;
            modalDataForm.show();
            document.getElementById('mainRow').style.display = "block";
            document.getElementById('loader').style.display = "none";
        });
    }
</script>
<script>
    var deleteForm = document.getElementById('deleteForm');
    dataForm.onreset = function() {
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