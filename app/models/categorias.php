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

    public function addCategory($data){
        $this->values = [
            'nombre_categoria' => $data['nombre_categoria'],
            'descripcion' => $data['descripcion'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->insert('categorias', $this->values);

        if($result){
            return ['status' => true, 'message' => 'Categoría agregada correctamente'];
        } else {
            return ['status' => false, 'message' => 'Error al agregar la categoría'];
        }
    }

    public function deleteCategory($id){
        $result = $this->delete('categorias', $id);

        if($result){
            return ['status' => true, 'message' => 'Categoría eliminada correctamente'];
        } else {
            return ['status' => false, 'message' => 'Error al eliminar la categoría'];
        }
    }
}