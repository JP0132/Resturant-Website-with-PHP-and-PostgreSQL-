<?php
class Database
{
    private $host = 'localhost';
    private $port = '5432';
    private $dbname = 'ResturantDB';
    private $user = 'postgres';
    private $password = 'Rainbow7';
    protected $db;

    public function __construct()
    {
        $dsn = "pgsql:host=$this->host;port=$this->port;dbname=$this->dbname;user=$this->user;password=$this->password";
        try {
            $this->db = new PDO($dsn);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit();
        }
    }

    public function getConnection()
    {
        return $this->db;
    }
}


// function connectToDatabase()
// {
//     // Setup database connection
//     $servername = "localhost";
//     $port = "5432";
//     $username = "postgres";
//     $password = "Rainbow7";
//     $dbname = "ResturantDB";
//     // Create connection
//     $conn = "pgsql:host=$servername port=$port dbname=$dbname user=$username password=$password";
//     try {
//         $db = new PDO($conn);
//         echo "Connected to the database successfully!";
//     } catch (PDOException $e) {
//         echo "Connection failed: " . $e->getMessage();
//     }
// }

?>