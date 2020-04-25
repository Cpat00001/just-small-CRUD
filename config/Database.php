<?php
class Database {
    // properties DB connection 
    private $host = 'localhost';
    private $db_name = 'myblog2';
    private $password = '123456';
    private $username = 'root';
    private $conn;
    

    //method to connect DB
    public function connectDB(){
        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
        }catch(PDOException $e){
            echo "Error!: ". $e->getMessage();
        }
        return $this->conn;
    }
}