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
}