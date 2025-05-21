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
}
