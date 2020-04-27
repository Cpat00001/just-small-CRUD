<?php
//headers
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Methods:Access-Control-Allow-Methods,Content-Type,Access-Control-Allow-Methods');


    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    //instantiate DB && connect
    $database = new Database();
    $db = $database->connectDB();

    //instantiate blog POST
    $post = new Post($db);

    //decode from JSOn format and Get raw posted data from User input.
    $data = json_decode(file_get_contents("php://input"));

    //assign to post data received form file_get_contnents("php://input")
    $post->title = $data->title;
    $post->body = $data->body;
    $post->author = $data->author;
    $post->category_id = $data->category_id;

    //create a post
    if($post->create()){
        echo json_encode(array('message' => 'Post was created'));
    }else{
        echo json_encode(array('message' => 'Sorry, Post was NOT created'));
    };


