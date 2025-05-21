<?php
    include_once LAYOUTS . 'main_head.php';

    setHeader($d);
   
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4>Autores</h4>
        <button class="btn btn-success rounded-circle" title="Agregar libro">
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
            app.loadAuthors();
            
        })
    </script>

<?php

    closefooter();
