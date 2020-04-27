<?php
//headers
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE'); 
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
    //get ID in order to DELETE proper record in DB
    $post->id = $data->id; 

    //Delete post
    if($post->delete()){
        echo json_encode(array('message' => 'Post was Deleted'));
    }else{
        echo json_encode(array('message' => 'Sorry, Post was NOT deleted'));
    };






