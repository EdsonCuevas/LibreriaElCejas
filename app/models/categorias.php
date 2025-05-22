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

    public function updateCategory($data){
        // Obtener los datos actuales de la categoría desde la base de datos
        $sql = "SELECT nombre_categoria, descripcion FROM categorias WHERE id = " . intval($data['id']);
        $result = $this->table->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $current = $result->fetch_assoc();

            // Verificar si los datos son iguales
            if (
                $current['nombre_categoria'] === $data['nombre_categoria'] &&
                $current['descripcion'] === $data['descripcion']
            ) {
                return ['status' => true, 'message' => 'No se detectaron cambios en la categoría.'];
            }
        }

        // Si hay cambios, proceder con la actualización
        $this->values = [
            'nombre_categoria' => $data['nombre_categoria'],
            'descripcion' => $data['descripcion'],
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->update('categorias', $this->values, $data['id']);

        if ($result) {
            return ['status' => true, 'message' => 'Categoría actualizada correctamente'];
        } else {
            return ['status' => false, 'message' => 'Error al actualizar la categoría'];
        }
    }

}