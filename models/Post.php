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

    //Get posts
    public function read(){
        // query first - get data from DB
        // Create query
        $query = 'SELECT 
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.createad_at
                FROM 
                ' . $this->table . ' p 
                LEFT JOIN 
                    categories c
                ON p.category_id = c.id
                ORDER BY 
                    p.createad_at DESC';
        //prepare statement
         $stmt = $this->conn->prepare($query);
         //execute prepraed statement
         $stmt->execute();

         return $stmt;
    }


}