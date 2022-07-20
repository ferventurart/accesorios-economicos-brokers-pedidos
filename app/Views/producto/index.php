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
                    <label class="form-label" for="categoriasProductoSearch"><i class="fa-solid fa-filter"></i>&nbsp;Filtrar por Categoria</label>
                    <select class="form-select" id="categoriasProductoSearch" name="categoriasProductoSearch">
                        <option value="">Seleccione una opci&oacute;n</option>
                        <?php foreach ($categoriasProducto as $value) {
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
                                        <th>SKU</th>
                                        <th>Nombre</th>
                                        <th>P. Venta</th>
                                        <th>Estado</th>
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
                        <form id="dataForm" method="POST" action="<?= base_url('productos') ?>" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <input class="form-control" type="hidden" id="id" name="id" value="0" />
                            <div class="mb-3">
                                <label class="form-label">C&oacute;digo de Barra</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-barcode"></i></span>
                                    <input class="form-control" type="text" id="codigo_barra" name="codigo_barra" placeholder="Ingrese el c&oacute;digo de barra" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">SKU</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-fingerprint"></i></span>
                                    <input class="form-control" type="text" id="sku" name="sku" placeholder="Ingrese el sku del producto" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre del producto" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Precio Broker</label>
                                <input class="form-control" type="text" id="precio_broker" name="precio_broker" placeholder="Ingrese el precio para broker" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'rightAlign': false, 'placeholder': '0'" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Precio Venta</label>
                                <input class="form-control" type="text" id="precio_venta" name="precio_venta" placeholder="Ingrese el precio para el p&uacute;blico" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'rightAlign': false, 'placeholder': '0'" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Categoria de Producto</label>
                                <select class="form-select" id="categoria_id" name="categoria_id">
                                    <option value="">Seleccione una opci&oacute;n</option>
                                    <?php foreach ($categoriasProducto as $value) {
                                    ?>
                                        <option value="<?= $value['id']; ?>"><?= $value['nombre']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="direccion">Descripci&oacute;n</label>
                                <textarea rows="2" class="form-control" id="descripcion" name="descripcion" placeholder="Ingrese una descripci&oacute;n del producto"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="file">Imagen del Producto</label>
                                <div class="text-left">
                                    <img alt="" id="imageUpload" src="<?= base_url() . "/img/resources/add-picture.png" ?>" class="img-responsive mt-2" width="128" height="128">
                                    <div class="mt-2">
                                        <label for="finput" class="btn btn-primary"><i class="fas fa-upload"></i> Subir</label>
                                    </div>
                                    <small>Para obtener mejores resultados, use una imagen de al menos 128 px por 128 px en formato .jpg</small>
                                    <input type="file" name="file" id="finput" style="visibility:hidden;" accept="image/*" onchange="onFileUpload(this);">
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="activo" name="activo" value="1" checked>
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
                        <form id="deleteForm" method="POST" action="<?= base_url('delete-producto') ?>">
                            <?= csrf_field() ?>
                            <input class="form-control" type="hidden" id="deleteId" name="deleteId" value="0" />
                            <p id="deleteMessage">¿Esta seguro de eliminar el registro seleccionado?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn btn-danger"><i class="fa-solid fa-trash-can"></i></i>&nbsp;Si, eliminarlo.</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END modalDeleteForm modal -->
        <div class="modal fade" id="modalPrintSku" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-secondary">
                        <h5 class="modal-title text-white">Imprimir Etiqueta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body m-3" id="body-print">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END modalPrintSku modal -->
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
        $('.sidebar-productos').addClass('active');
        new TomSelect("#categoriasProductoSearch", {
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
                url: "<?= base_url('get-productos') ?>",
                data: function(d) {
                    d.categoriaProductoSearch = $('#categoriasProductoSearch').val();
                }
            },
            columnDefs: [{
                targets: [3, 4, 5, -1],
                orderable: false,
                className: 'text-center'
            }]
        });

        $('#categoriasProductoSearch').change(function(event) {
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
                precio_broker: {
                    validators: {
                        notEmpty: {},
                        numeric: {
                            thousandsSeparator: ',',
                            decimalSeparator: '.',
                        },
                    },
                },
                precio_venta: {
                    validators: {
                        notEmpty: {},
                        numeric: {
                            thousandsSeparator: ',',
                            decimalSeparator: '.',
                        },
                    },
                },
                categoria_id: {
                    validators: {
                        notEmpty: {},
                    },
                },
                descripcion: {
                    validators: {
                        stringLength: {
                            max: 150
                        }
                    },
                },
                sku: {
                    validators: {
                        stringLength: {
                            max: 70
                        }
                    },
                },
                codigo_barra: {
                    validators: {
                        stringLength: {
                            max: 100
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
    const categoriaIdSelect = new TomSelect("#categoria_id", {
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
        fetch(`<?= base_url('get-producto') ?>/${id}`, {
            method: "get",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            }
        }).then(response => {
            return response.json()
        }).then((producto) => {
            console.log(producto);
            document.getElementById('id').value = producto.id;
            document.getElementById('nombre').value = producto.nombre;
            document.getElementById('precio_broker').value = producto.precio_broker;
            document.getElementById('precio_venta').value = producto.precio_venta;
            categoriaIdSelect.setValue(producto.categoria_id);
            document.getElementById('descripcion').value = producto.descripcion;
            document.getElementById('sku').value = producto.sku;
            document.getElementById('codigo_barra').value = producto.codigo_barra;
            document.getElementById("activo").checked = producto.activo == "1" ? true : false;
            document.getElementById("activo").disabled = false;
            document.getElementById("imageUpload").src = producto.imagen_producto == null ? "<?= base_url() . "/img/resources/add-picture.png" ?>" : producto.imagen_producto;
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
<script>
    const imprimirSku = (sku) => {
        window.open(`<?= base_url('get-sku-printable') ?>/${sku}`, "_blank");
    }
</script>
<script>
    function onFileUpload(input, id) {
        id = id || '#imageUpload';
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(id).attr('src', e.target.result).width(128).height(128)
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?= $this->endSection() ?>