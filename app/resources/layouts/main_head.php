<?php
    function setHeader($args){
        
        
?>
<!DOCTYPE html>
<html lang="es">
<head>    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?=CSS?>bootstrap.css">
 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title><?=$args->title?></title>
    <style>
        body {
            color: #888;
            background-color : #CCC;
        }
    </style> 
</head>
<body>
<div id="app" class="container-fluid p-0 sticky-top">
        <header class="row m-0 bg-dark bg-gradient" data-bs-theme="dark">
            <div class="col-9">
                <h1 class="ml-3 mt-2">Libreria El Cejas</h1>                      
            </div>
            <div class="col-3 mt-2">
                <form class="d-flex" role="search">
                    <input class="form-control me-2" id="buscar-palabra" type="search" placeholder="Buscar" aria-label="Search">
                    <button class="btn btn-outline-success" onclick="" type="button"><i class="bi bi-search"></i></button>
                </form>
            </div>
        </header>
        <nav class="navbar navbar-expand-lg bg-dark bg-gradient mb-3" data-bs-theme="dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex flex-row">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/">Libros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/">Autores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/">Categorias</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>    
<?php
}
