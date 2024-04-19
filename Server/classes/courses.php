<?php

class Courses
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllData()
    {
        try {
            $query = "SELECT * FROM courses";
            $statement = $this->db->query($query);
            $courses = $statement->fetchAll(PDO::FETCH_ASSOC);
            // $data = [];
            // foreach ($courses as $course) {
            //     $data[] = $course["name"];
            // }
            return $courses;
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return false;
        }
    }
}



// Include the database connection file
// require_once "C:/xampp/htdocs/ResturantWebsite/Server/db.php";

// $db = connectToDatabase();
// if (!$db) {
//     exit("Failed to connect to the database.");
// }

// // Define your database queries or functions here
// function getAllCourses()
// {
//     try {
//         $query = "SELECT * FROM courses"; // Change this to your actual table name
//         $statement = $db->query($query);
//         $results = $statement->fetchAll(PDO::FETCH_ASSOC);
//         return $results;
//     } catch (PDOException $e) {
//         echo "Query failed: " . $e->getMessage();
//         return false;
//     }
// }

// // Execute a query to fetch the categories
// $query = "SELECT * FROM courses";
// $courses = pg_query($conn, $query);
// if (!$result) {
//     echo "Error: Query execution failed.";
//     exit;
// }


// pg_close($conn);

// // Return courses array
// return $courses;

?>