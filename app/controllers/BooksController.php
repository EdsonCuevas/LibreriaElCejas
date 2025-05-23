<?php

namespace app\controllers;

use app\models\libros as libros;
use app\classes\Views as View;

class BooksController extends Controller {
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $response = ['title' => 'Libros'];
        View::render('books', $response);
    }

    public function getBooks(){
        $book = new libros();
        echo $book->getAllBooks();
    }

    public function addBook(){
    $book = new libros();
    $data = $_POST;
    $rutaImagen = null;

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreOriginal = $_FILES['imagen']['name'];
        $tmpPath = $_FILES['imagen']['tmp_name'];
        $ext = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
        $nombreFinal = uniqid('img_') . '.' . $ext;
        $rutaDestino = 'uploads/' . $nombreFinal;

        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        if (move_uploaded_file($tmpPath, $rutaDestino)) {
            $rutaImagen = $rutaDestino;
        } else {
            echo json_encode(['status' => false, 'message' => 'Error al subir la imagen.']);
            return;
        }
    }

    $data['imagen'] = '/' . $rutaImagen; // nombre del campo según tu modelo
    $result = $book->save($data);

    echo json_encode([
        'status' => $result,
        'message' => $result ? 'Libro guardado correctamente.' : 'Error al guardar el libro.'
    ]);
}

    public function updateBook() {
        $book = new libros();
        $data = $_POST;

        // Verificar si hay imagen nueva
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $nombreOriginal = $_FILES['imagen']['name'];
            $tmpPath = $_FILES['imagen']['tmp_name'];
            $ext = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
            $nombreFinal = uniqid('img_') . '.' . $ext;
            $rutaDestino = 'uploads/' . $nombreFinal;

            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }

            if (move_uploaded_file($tmpPath, $rutaDestino)) {
                $data['imagen'] = '/' . $rutaDestino;
            } else {
                echo json_encode([
                    'status' => false,
                    'message' => 'Error al subir la nueva imagen.'
                ]);
                return;
            }
        } else {
            // Si no se subió imagen nueva, no actualizar el campo 'imagen'
            unset($data['imagen']);
        }

        $result = $book->updateBook($data);

        echo json_encode([
            'status' => $result,
            'message' => $result ? 'Libro actualizado correctamente.' : 'Error al actualizar el libro.'
        ]);
    }


    public function deleteBook() {
        $book = new libros();
        $data = $_POST;
        $result = $book->deleteBook($data);

        echo json_encode([
            'status' => $result,
            'message' => $result ? 'Libro eliminado correctamente.' : 'Error al eliminar el libro.'
        ]);
    }



}
