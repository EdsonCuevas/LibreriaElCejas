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
