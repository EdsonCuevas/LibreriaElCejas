<?php
namespace app\models;

class libros extends Model {

    protected $table;
    
    protected $fillable = [
        'titulo',
        'isbn',
        'autor_id',
        'categoria_id',
        'fecha_publicacion',
        'numero_paginas',
        'idioma',
        'created_at',
        'updated_at'
    ];

    public function __construct(){
        parent::__construct();
        $this->table = $this->connect();
    }

    public $values = [];

    public function getAllBooks($limit = 10){
        $result = $this->select([
                                'a.id',
                                'a.titulo',
                                'a.isbn',
                                'a.fecha_publicacion',
                                'a.numero_paginas',
                                'a.idioma',
                                'a.created_at',
                                'a.updated_at',
                                'b.nombre_completo as autor',
                                'c.nombre_categoria as categoria'
                            ])
                        ->join('autores b', 'a.autor_id = b.id')
                        ->join('categorias c', 'a.categoria_id = c.id')
                        ->orderBy([['a.id', 'desc']])
                        ->limit($limit)
                        ->get();

        return $result;
    }
}
