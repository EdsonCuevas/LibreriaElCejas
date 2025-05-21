<?php
namespace app\models;

class categorias extends Model {

    protected $table;
    
    protected $fillable = [
        'nombre_categoria',
        'descripcion',
        'created_at',
        'updated_at'
    ];

    public function __construct(){
        parent::__construct();
        $this->table = $this->connect();
    }

    public $values = [];

    public function getAllCategories($limit = 10){
        $result = $this->select([
                                'id',
                                'nombre_categoria',
                                'descripcion',
                                'created_at',
                                'updated_at'
                            ])
                        ->orderBy([['id', 'desc']])
                        ->limit($limit)
                        ->get();

        return $result;
    }
}