<?php
namespace app\models;

class autores extends Model {

    protected $table;
    
    protected $fillable = [
        'nombre_completo',
        'nacionalidad',
        'fecha_nacimiento',
        'created_at',
        'updated_at'
    ];

    public function __construct(){
        parent::__construct();
        $this->table = $this->connect();
    }

    public $values = [];

    public function getAllAuthors($limit = 10){
        $result = $this->select([
                                'id',
                                'nombre_completo',
                                'nacionalidad',
                                'fecha_nacimiento',
                                'created_at',
                                'updated_at'
                            ])
                        ->orderBy([['id', 'desc']])
                        ->limit($limit)
                        ->get();

        return $result;
    }
}