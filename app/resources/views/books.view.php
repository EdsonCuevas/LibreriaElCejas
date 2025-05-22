<?php
    include_once LAYOUTS . 'main_head.php';

    setHeader($d);
   
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4>Libros</h4>
        <button class="btn btn-success rounded-circle" title="Agregar libro">
            <i class="bi bi-plus-lg"></i>
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle text-center" id="booksTable">
            <thead class="table-dark">
                <tr>
                    <th>Título</th>
                    <th>ISBN</th>
                    <th>Autor</th>
                    <th>Categoria</th>
                    <th>Fecha Publicación</th>
                    <th>Páginas</th>
                    <th>Idioma</th>
                    <th>Fecha de Agregación</th>
                    <th>Fecha de Actualización</th>
                    <th>Operaciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí irán los libros -->
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalVerLibro" tabindex="-1" aria-labelledby="modalVerLibroLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title" id="modalVerLibroLabel">Detalles del Libro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      
      <div class="modal-body">
        <div class="row">
        
          <!-- Imagen del libro -->
          <div class="col-md-4 text-center">
            <img id="verLibroImagen" src="" alt="Portada del libro" class="img-fluid border rounded" style="max-height: 350px;">
          </div>

          <!-- Detalles del libro -->
          <div class="col-md-8">
            <small id="verLibroGenero" class="text-muted d-block mb-1"></small>
            <h4 id="verLibroTitulo"></h4>
            <p id="verLibroAutor" class="text-muted mb-3"></p>

            <div class="mb-2">
              <i class="bi bi-calendar-event"></i>
              <strong>Año:</strong> <span id="verLibroAnio"></span>
            </div>
            <div class="mb-2">
              <i class="bi bi-file-earmark-text"></i>
              <strong>Páginas:</strong> <span id="verLibroPaginas"></span>
            </div>
            <div class="mb-2">
              <i class="bi bi-hash"></i>
              <strong>ISBN:</strong> <span id="verLibroIsbn"></span>
            </div>
            <div class="mb-3">
              <i class="bi bi-translate"></i>
              <strong>Idioma:</strong> <span id="verLibroIdioma"></span>
            </div>

            <div>
              <strong>Sinopsis:</strong>
              <p id="verLibroSinopsis"></p>
            </div>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>



<?php
    include_once LAYOUTS . 'main_foot.php';

    setFooter($d);

?>
    <script>//Script de la vusta Home
        $( function (){
            app.loadBooks();
        })
    </script>

<?php

    closefooter();
