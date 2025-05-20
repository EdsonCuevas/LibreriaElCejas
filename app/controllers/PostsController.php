<?php

    namespace app\controllers;

    use app\models\posts as posts;
    use app\models\comments as comments;
    use app\models\interactions as inter;

    class PostsController extends Controller {
        public function __construct(){
            parent::__construct();
        }

        public function index(){}

        public function getPosts(){
            $posts = new posts();
            echo $posts->getAllPosts(5);
        }

        public function getLastPost( $params = null){
            $post = new posts();
            $rp = json_decode( $post -> getLastPost() );
            if( count( $rp ) > 0){
                $comments = new comments();
                $rc = $comments -> count('postId')
                                -> where([['postId',$rp[0]->id]])
                                -> get();
                $inter = new inter();
                $ri = $inter -> count('postId')
                            -> where([['postId',$rp[0]->id]])
                            -> get();
                echo json_encode( array_merge( $rp, json_decode( $ri ), json_decode( $rc )));
            }

        }
        public function openPost( $params = null){
            $post = new posts();
            $pid = $params[2];
            $rp = json_decode( $post -> openPost( $pid ) );
            if( count( $rp ) > 0){
                $comments = new comments();
                $rc = $comments -> count('postId')
                                -> where([['postId',$pid]])
                                -> get();
                $inter = new inter();
                $ri = $inter -> count('postId')
                            -> where([['postId',$pid]])
                            -> get();
                echo json_encode( array_merge( $rp, json_decode( $ri ), json_decode( $rc )));
            }

        }

        public function getComments( $params = null){
            $comments = new comments();
            $pid = $params[2];
            echo $comments -> getComments( $pid );
        }
    }