<?php

    namespace app\models;

    class interactions extends Model {

        protected $table;
        protected $fillable = [
            'postId',
            'userId',
            'tipo',
            'created_at'
        ];

        public function __construct(){
            parent::__construct();
            $this->table = $this->connect();
        }
        public $values = [];

    }