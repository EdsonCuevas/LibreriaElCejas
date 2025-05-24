<?php

namespace app\controllers;

use app\models\autores as autores;
use app\classes\Views as View;


class AuthorsController extends Controller {
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $response = ['title' => 'Autores'];
        View::render('authors', $response);
    }

    public function getAuthors(){
        $author = new autores();
        echo $author->getAllAuthors();
    }

    public function addAuthor(){
        $author = new autores();
        $response = $author->addAuthor($_POST);
        echo json_encode($response);
    }
    public function deleteAuthor(){
        $author = new autores();
        $response = $author->deleteAuthor($_POST['id']);
        echo json_encode($response);
    }
   public function editAuthor(){
        $author = new autores();
        $data = $_POST;
        
        // Log para depuración
        error_log("Datos recibidos para editar: " . print_r($data, true));
        
        $response = $author->editAuthor($data);
        echo json_encode($response);
    }
}