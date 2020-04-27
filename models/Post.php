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
    // create a POST
    public function create(){
        $query = 'INSERT INTO ' . $this->table . '
            SET 
            title = :title,
            body = :body,
            author = :author,
            category_id = :category_id';
        
    //prepare statement
    $stmt = $this->conn->prepare($query);
    //Clean data submitted by Users. 
    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->body = htmlspecialchars(strip_tags($this->body));
    $this->author = htmlspecialchars(strip_tags($this->author));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id)); 

    //bind named parameters
    $stmt->bindParam(':title',$this->title);
    $stmt->bindParam(':body',$this->body);
    $stmt->bindParam(':author',$this->author);
    $stmt->bindParam(':category_id',$this->category_id);

    //execute query
    if($stmt->execute()){
        return true;
    };
    //if something wrong -> print an error
    printf("Error: %s.\n", $stmt->error);

    return false;
 }
 //UPDATE Post
 public function update(){
    $query = 'UPDATE ' . $this->table . '
        SET 
            title = :title,
            body = :body,
            author = :author,
            category_id = :category_id
        WHERE id= :id';
    
//prepare statement
$stmt = $this->conn->prepare($query);
//Clean data submitted by Users. 
$this->id = htmlspecialchars(strip_tags($this->id));
$this->title = htmlspecialchars(strip_tags($this->title));
$this->body = htmlspecialchars(strip_tags($this->body));
$this->author = htmlspecialchars(strip_tags($this->author));
$this->category_id = htmlspecialchars(strip_tags($this->category_id)); 

//bind named parameters
$stmt->bindParam(':id',$this->id);
$stmt->bindParam(':title',$this->title);
$stmt->bindParam(':body',$this->body);
$stmt->bindParam(':author',$this->author);
$stmt->bindParam(':category_id',$this->category_id);

//execute query
if($stmt->execute()){
    return true;
};
//if something wrong -> print an error
printf("Error: %s.\n", $stmt->error);

return false;
}
//DELETE Post
public function delete(){
    //query to DELETE from DB
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

    //preprare statement
    $stmt = $this->conn->prepare($query);
    //clear ID given from User
    $this->id = htmlspecialchars(strip_tags($this->id));
    //bind params ID
    $stmt->bindParam(':id',$this->id);
   
    //execute query
        if($stmt->execute()){
            return true;
        };
        //if something wrong -> print an error
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}