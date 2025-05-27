<?php
    include_once LAYOUTS . 'main_head.php';

    setHeader($d);
   
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4>Autores</h4>
        <button class="btn btn-success rounded-circle" title="Agregar autor" data-bs-toggle="modal" data-bs-target="#modalAgregarAutor">
            <i class="bi bi-plus-lg"></i>
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle text-center" id="authorsTable">
            <thead class="table-dark">
                <tr>
                    <th>Nombre Completo</th>
                    <th>Nacionalidad</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Fecha de Agregación</th>
                    <th>Fecha de Actualización</th>
                    <th>Operaciones</th>
                </tr>
            </thead>
            <tbody id="authorsTableBody">
                <!-- Aquí irán los autores -->
            </tbody>
        </table>
    </div>

<!-- Modal para agregar autor -->
<div class="modal fade" id="modalAgregarAutor" tabindex="-1" aria-labelledby="modalAgregarAutorLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAgregarAutorLabel">Agregar nuevo autor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="formAgregarAutor">
          <div class="mb-3">
            <label for="nombreCompleto" class="form-label">Nombre completo</label>
            <input type="text" class="form-control" id="nombreCompleto" name="nombre_completo" required>
          </div>
          <div class="mb-3">
            <label for="nacionalidad" class="form-label">Nacionalidad</label>
            <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" required>
          </div>
          <div class="mb-3">
            <label for="fechaNacimiento" class="form-label">Fecha de nacimiento</label>
            <input type="date" class="form-control" id="fechaNacimiento" name="fecha_nacimiento" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" form="formAgregarAutor" class="btn btn-primary">Guardar autor</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para editar autor -->
<div class="modal fade" id="modalEditarAutor" tabindex="-1" aria-labelledby="modalEditarAutorLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarAutorLabel">Editar autor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="formEditarAutor">
          <input type="hidden" id="editAutorId" name="id">
          <div class="mb-3">
            <label for="editNombreCompleto" class="form-label">Nombre completo</label>
            <input type="text" class="form-control" id="editNombreCompleto" name="nombre_completo" required>
          </div>
          <div class="mb-3">
            <label for="editNacionalidad" class="form-label">Nacionalidad</label>
            <input type="text" class="form-control" id="editNacionalidad" name="nacionalidad" required>
          </div>
          <div class="mb-3">
            <label for="editFechaNacimiento" class="form-label">Fecha de nacimiento</label>
            <input type="date" class="form-control" id="editFechaNacimiento" name="fecha_nacimiento" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" form="formEditarAutor" class="btn btn-primary">Actualizar autor</button>
      </div>
    </div>
  </div>
</div>

<?php
    include_once LAYOUTS . 'main_foot.php';

    setFooter($d);

?>

    <script>
        $( function (){ 
            app.loadAuthors();
            $(document).ready(function () {
                $("#formAgregarAutor").on("submit", function (e) {
                    e.preventDefault(); // Prevenir el submit tradicional
                    app.addAuthor();  // Llamar a la función personalizada
                });

                $("#formEditarAutor").on("submit", function (e) {
                    e.preventDefault();
                    app.editAuthor();
                });
            });

            app.showEditModalAutor = function (author) {
                $('#editAutorId').val(author.id);
                $('#editNombreCompleto').val(author.nombre_completo);
                $('#editNacionalidad').val(author.nacionalidad);
                $('#editFechaNacimiento').val(author.fecha_nacimiento);
                $('#modalEditarAutor').modal('show');
            };
        })
    </script>

<?php

    closefooter();
