<?php
    //headers
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    //instantiate DB && connect
    $database = new Database();
    $db = $database->connectDB();

    //instantiate blog POST
    $post = new Post($db);
    //blog post query
    $result = $post->read();

    //count rows in result / return the number of rows affected by the last SQL statement
    $num = $result->rowCount();

    //check if any post exists
    if($num > 0){
        //post array
        $post_arr = array();
        
        //loop through $result with data
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            //assign values you have now from extract()
            $post_item = array(
                'id'=> $id,
                'title'=>$title,
                //in body Convert HTML entities to their corresponding characters
                'body'=> html_entity_decode($body),
                'author'=> $author,
                'category_id'=> $category_id,
                'category_name'=> $category_name
            );
            //push to $post_item/single post  to $post_arr as array of posts(array)
            array_push($post_arr,$post_item);
        }
        //change php result array into JSON Object && output
        echo json_encode($post_arr);

    }else{
        echo json_encode(array('msg'=>'No Posts Found'));
    }




