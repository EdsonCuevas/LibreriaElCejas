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

    public function addCategory(){
        $category = new categorias();
        $response = $category->addCategory($_POST);
        echo json_encode($response);
    }

    public function updateCategory(){
        $category = new categorias();
        $response = $category->updateCategory($_POST);
        echo json_encode($response);
    }

    public function deleteCategory(){
        $category = new categorias();
        $response = $category->deleteCategory($_POST['id']);
        echo json_encode($response);
    }
}