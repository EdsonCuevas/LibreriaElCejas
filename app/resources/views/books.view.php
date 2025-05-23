<?php
    include_once LAYOUTS . 'main_head.php';

    setHeader($d);
   
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4>Libros</h4>
        <button class="btn btn-success rounded-circle" id="btnAbrirModalAgregarLibro" title="Agregar libro" data-bs-toggle="modal" data-bs-target="#modalAgregarLibro">
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

<!-- Modal Agregar Libro -->
<div class="modal fade" id="modalAgregarLibro" tabindex="-1" aria-labelledby="modalAgregarLibroLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="formAgregarLibro" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAgregarLibroLabel">Agregar Libro</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="titulo" class="form-label">Título</label>
              <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="col-md-6">
              <label for="autor" class="form-label">Autor</label>
              <select class="form-select" id="selectAutor" name="autor_id" required></select>
                <option value="">Seleccione un autor</option>
                <!-- Aquí se llenarán los autores desde la base de datos -->
              </select>
            </div>
            <div class="col-md-6">
              <label for="categoria" class="form-label">Categoría</label>
              <select class="form-select" id="selectCategoria" name="categoria_id" required></select>
                <option value="">Seleccione una categoría</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="isbn" class="form-label">ISBN</label>
              <input type="text" class="form-control" id="isbn" name="isbn" required>
            </div>
            <div class="col-md-6">
              <label for="fecha_publicacion" class="form-label">Fecha de Publicación</label>
              <input type="date" class="form-control" id="fecha_publicacion" name="fecha_publicacion" required>
            </div>
            <div class="col-md-6">
              <label for="idioma" class="form-label">Idioma</label>
              <select class="form-select" id="idioma" name="idioma" required>
                <option value="">Seleccione un idioma</option>
                <option value="Español">Español</option>
                <option value="Inglés">Inglés</option>
                <option value="Francés">Francés</option>
                <!-- Agrega más idiomas si es necesario -->
              </select>
            </div>
            <div class="col-md-6">
              <label for="numero_paginas" class="form-label">Número de páginas</label>
              <input type="number" class="form-control" id="numero_paginas" name="numero_paginas" min="1" required>
            </div>
            <div class="col-md-6">
              <label for="imagen" class="form-label">Portada</label>
              <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
            </div>
            <div class="col-12">
              <label for="sinopsis" class="form-label">Sinopsis</label>
              <textarea class="form-control" id="sinopsis" name="sinopsis" rows="4" placeholder="Sinopsis del libro..." required></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Agregar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Editar Libro -->
<div class="modal fade" id="modalEditarLibro" tabindex="-1" aria-labelledby="modalEditarLibroLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="formEditarLibro" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditarLibroLabel">Editar Libro</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="editLibroId" name="id"> <!-- ID oculto -->
          <div class="row g-3">
            <div class="col-md-6">
              <label for="editTitulo" class="form-label">Título</label>
              <input type="text" class="form-control" id="editTitulo" name="titulo" required>
            </div>
            <div class="col-md-6">
              <label for="editAutor" class="form-label">Autor</label>
              <select class="form-select" id="editAutor" name="autor_id" required>
                <option value="">Seleccione un autor</option>
                <!-- Se llenará dinámicamente -->
              </select>
            </div>
            <div class="col-md-6">
              <label for="editCategoria" class="form-label">Categoría</label>
              <select class="form-select" id="editCategoria" name="categoria_id" required>
                <option value="">Seleccione una categoría</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="editIsbn" class="form-label">ISBN</label>
              <input type="text" class="form-control" id="editIsbn" name="isbn" required>
            </div>
            <div class="col-md-6">
              <label for="editFechaPublicacion" class="form-label">Fecha de Publicación</label>
              <input type="date" class="form-control" id="editFechaPublicacion" name="fecha_publicacion" required>
            </div>
            <div class="col-md-6">
              <label for="editIdioma" class="form-label">Idioma</label>
              <select class="form-select" id="editIdioma" name="idioma" required>
                <option value="">Seleccione un idioma</option>
                <option value="Español">Español</option>
                <option value="Inglés">Inglés</option>
                <option value="Francés">Francés</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="editNumeroPaginas" class="form-label">Número de páginas</label>
              <input type="number" class="form-control" id="editNumeroPaginas" name="numero_paginas" min="1" required>
            </div>
            <div class="col-md-6">
              <label for="editImagen" class="form-label">Portada</label>
              <input type="file" class="form-control" id="editImagen" name="imagen" accept="image/*">
            </div>
            <div class="col-12">
              <label for="editSinopsis" class="form-label">Sinopsis</label>
              <textarea class="form-control" id="editSinopsis" name="sinopsis" rows="4" required></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar cambios</button>
        </div>
      </div>
    </form>
  </div>
</div>


<!-- Modal Ver Libro -->
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

            $('#btnAbrirModalAgregarLibro').on('click', function () {
                app.loadAuthorsSelect();
                app.loadCategoriesSelect();
                $('#modalAgregarLibro').modal('show');
              });


            $('#formAgregarLibro').on('submit', function (e) {
            e.preventDefault();
            app.addBook();
            });

            $('#formEditarLibro').on('submit', async function (e) {
              e.preventDefault();

              const form = document.getElementById('formEditarLibro');
              const formData = new FormData(form);

              try {
                  const response = await $.ajax({
                      url: '/Books/updateBook',
                      method: 'POST',
                      data: formData,
                      contentType: false,
                      processData: false,
                  });
                  console.log('Respuesta del servidor:', response);
                  if (response) {
                      $('#modalEditarLibro').modal('hide');
                      app.loadBooks();
                      Swal.fire('¡Actualizado!', response.message, 'success');
                  } else {
                      Swal.fire('Error', response.message || 'No se pudo actualizar el libro.', 'error');
                  }

              } catch (error) {
                  console.error('Error actualizando libro:', error);
                  Swal.fire('Error', 'Hubo un problema al actualizar el libro.', 'error');
              }
          });

        })
    </script>

<?php

    closefooter();
