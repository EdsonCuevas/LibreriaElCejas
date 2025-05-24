<?php
namespace app\models;

class autores extends Model {

    protected $table;
    
    protected $fillable = [
        'id',
        'nombre_completo',
        'nacionalidad',
        'fecha_nacimiento',
        'created_at',
        'updated_at'
    ];

    protected $primaryKey = 'id';
    protected $autoIncrement = true;

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

    public function addAuthor($data) {
        try {
            $this->values = [
                'nombre_completo' => $data['nombre_completo'],
                'nacionalidad' => $data['nacionalidad'],
                'fecha_nacimiento' => $data['fecha_nacimiento'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $this->insert('autores', $this->values);
            
            if($result) {
                // Get the last inserted ID
                $id = $this->table->insert_id;
                return ['status' => true, 'message' => 'Autor agregado exitosamente', 'id' => $id];
            } else {
                return ['status' => false, 'message' => 'Error al agregar el autor'];
            }
        } catch (\Exception $e) {
            return ['status' => false, 'message' => 'Error al agregar el autor: ' . $e->getMessage()];
        }
    }
    public function deleteAuthor($id) {
        try {
            $result = $this->delete('autores', $id);
            if($result) {
                return ['status' => true, 'message' => 'Autor eliminado exitosamente'];
            } else {
                return ['status' => false, 'message' => 'Error al eliminar el autor'];
            }
        } catch (\Exception $e) {
            return ['status' => false, 'message' => 'Error al eliminar el autor: ' . $e->getMessage()];
        }
    }

public function editAuthor($data) {
    try {
        // Primero obtenemos el autor para verificar que existe
        $stmt = $this->table->prepare("SELECT * FROM autores WHERE id = ?");
        $stmt->bind_param("i", $data['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $author = $result->fetch_assoc();

        if (!$author) {
            return ['status' => false, 'message' => 'Autor no encontrado'];
        }

        // Actualizamos los datos usando una consulta preparada
        $stmt = $this->table->prepare("
            UPDATE autores SET 
                nombre_completo = ?,
                nacionalidad = ?,
                fecha_nacimiento = ?,
                updated_at = CURRENT_TIMESTAMP
            WHERE id = ?
        ");
        
        $stmt->bind_param("sssi", 
            $data['nombre_completo'],
            $data['nacionalidad'],
            $data['fecha_nacimiento'],
            $data['id']
        );
        
        // Ejecutamos la consulta
        $result = $stmt->execute();
        
        // Verificamos si la consulta se ejecutó correctamente
        if($result && $stmt->affected_rows > 0) {
            // Obtenemos los datos actualizados del autor
            $stmt = $this->table->prepare("SELECT * FROM autores WHERE id = ?");
            $stmt->bind_param("i", $data['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $updatedAuthor = $result->fetch_assoc();
            
            return [
                'status' => true, 
                'message' => 'Autor editado exitosamente',
                'data' => $updatedAuthor
            ];
        } else {
            return ['status' => false, 'message' => 'Error al editar el autor'];
        }
    } catch (\Exception $e) {
        return ['status' => false, 'message' => 'Error al editar el autor: ' . $e->getMessage()];
    }
}

}

