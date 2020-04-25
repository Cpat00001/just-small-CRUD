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

    //get SINGLE POST 
    public function read_single(){
        //query to get post from DB
        $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.createad_at
                        FROM ' . $this->table . ' p
                        LEFT JOIN
                            categories c ON p.category_id = c.id
                        WHERE
                            p.id = ?
                        LIMIT 0,1';
        //prepare statement
        $stmt = $this->conn->prepare($query);
        //bind ID to placeholder "?"
        $stmt->bindParam(1,$this->id);
        //execute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set properties to those from $row
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];

    }

}