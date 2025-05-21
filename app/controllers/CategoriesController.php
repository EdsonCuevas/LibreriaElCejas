<?php

namespace app\controllers;

use app\models\categorias as categorias;
use app\classes\Views as View;

class CategoriesController extends Controller {
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $response = ['title' => 'Categorias'];
        View::render('categories', $response);
    }

    public function getCategories(){
        $category = new categorias();
        echo $category->getAllCategories();
    }
}