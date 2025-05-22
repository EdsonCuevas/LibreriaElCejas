<?php
    include_once LAYOUTS . 'main_head.php';

    setHeader($d);
   
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4>Categorias</h4>
        <button class="btn btn-success rounded-circle" title="Agregar categoría"
                data-bs-toggle="modal" data-bs-target="#modalAgregarCategoria">
            <i class="bi bi-plus-lg"></i>
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle text-center" id="categoriesTable">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha de Agregación</th>
                    <th>Fecha de Actualización</th>
                    <th>Operaciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí irán las categorias -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para agregar categoría -->

<div class="modal fade" id="modalAgregarCategoria" tabindex="-1" aria-labelledby="modalAgregarCategoriaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title" id="modalAgregarCategoriaLabel">Agregar nueva categoría</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      
      <div class="modal-body">
        <form id="formAgregarCategoria">
          <div class="mb-3">
            <label for="nombreCategoria" class="form-label">Nombre de la categoría</label>
            <input type="text" class="form-control" id="nombreCategoria" name="nombre" required>
          </div>
          <div class="mb-3">
            <label for="descripcionCategoria" class="form-label">Descripción (opcional)</label>
            <textarea class="form-control" id="descripcionCategoria" name="descripcion" rows="3"></textarea>
          </div>
        </form>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" form="formAgregarCategoria" class="btn btn-primary">Guardar categoría</button>
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
            app.loadCategories();
            $(document).ready(function () {
            $("#formAgregarCategoria").on("submit", function (e) {
                e.preventDefault(); // Prevenir el submit tradicional
                app.addCategory();  // Llamar a tu función personalizada
            });
        });
        })
    </script>

<?php

    closefooter();
