<?php
class Database
{
    protected $db;

    public function __construct()
    {
        $config = include ('config.php');
        $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};user={$config['user']};password={$config['password']}";
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