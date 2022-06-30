<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<main class="content">
    <div class="container-fluid p-0">
        <?= show_flash_alert() ?>

        <h1 class="h3 mb-3"><?= $title; ?></h1>
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Listado de <?= $title; ?></h5>
                    </div>
                    <div class="card-body">
                        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-actions float-end">
                        </div>
                        <h5 class="card-title mb-0">Formulario de <?= $title; ?></h5>
                    </div>
                    <div class="card-body">
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
                            <div class="float-end mt-3">
                                <button type="submit" class="btn btn-lg btn-success"><i class="fas fa-save"></i> Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="<?= base_url('js/datatables.js') ?>"></script>
<script>
    $(document).ready(function() {
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
                orderable: false
            }, ]
        });
    });
</script>
<script>
    const obtener = (id) => {
        fetch(`<?= base_url('get-rol') ?>/${id}`, {
            method: "get",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            }
        }).then(response => {
            return response.json()
        }).then((rol) => {
            document.getElementById('id').value = rol.id;
            document.getElementById('nombre').value = rol.nombre;
            document.getElementById('descripcion').value = rol.descripcion;
        });
    }
    const borrar = (id) => {
        fetch(`<?= base_url('delete-rol') ?>/${id}`, {
            method: "get",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            }
        }).then(response => {
            return response.json()
        }).then((rol) => {
            alert(`Rol ${rol.nombre} eliminado exitosamente.`);
            $('#table').DataTable().ajax.reload();
        });
    }
</script>
<?= $this->endSection() ?>