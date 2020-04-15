<?php

class Post {
    //DB connection
    private $conn;
    private $table = 'posts';

    //POST Properites
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    //constructor
    function __construct($db){
        $this->conn = $db;
    }


}