<?php
class User
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function register($fullname, $email, $password)
    {
        try {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertQuery = "INSERT INTO users (fullname, email, password) VALUES (:fullname, :email, :password)";
            $insertQuery = $this->db->prepare($insertQuery);
            $insertQuery->bindParam(":email", $email);
            $insertQuery->bindParam(":password", $hashPassword);
            $insertQuery->bindParam(":fullname", $fullname);
            $insertQuery->execute();
            header("Content-Type: application/json");
            echo json_encode(array("success" => true, "message" => "You have been registered!"));
        } catch (PDOException $e) {
            header("Content-Type: application/json");
            echo json_encode(array("success" => false, "message" => "Connection failed: " . $e->getMessage()));
        }

    }

    public function login($email, $password)
    {
        try {
            $query = "SELECT * FROM users where email = :email";
            $query = $this->db->prepare($query);
            $query->bindParam(":email", $email);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($password, $user["password"])) {
                    $_SESSION['user_id'] = $user["user_id"];
                    $_SESSION['user_name'] = $user["fullname"];
                    $_SESSION['user_email'] = $email;
                    header("Content-Type: application/json");
                    echo json_encode(array("success" => true, "message" => "Login successful!"));
                    exit();
                } else {
                    // Incorrect password
                    echo json_encode(array("success" => false, "message" => "Invalid email or password."));
                }
            } else {
                // User not found
                echo json_encode(array("success" => false, "message" => "Invalid email or password."));
            }

        } catch (PDOException $e) {
            header("Content-Type: application/json");
            echo json_encode(array("success" => false, "message" => "Connection failed: " . $e->getMessage()));
        }
    }

    public function getUserNameById($id)
    {
        try {

            // Prepare and execute the query to fetch previous bookings
            $sql = "SELECT fullname FROM users WHERE user_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $userName = $stmt->fetch(PDO::FETCH_ASSOC);

            // Return the availability status for each requested timestamp
            if ($userName) {
                // Return the user's name
                return $userName['fullname'];
            } else {
                // Handle the case where user is not found
                return null;
            }
            //return array("success" => true, "previousBookings" => $previousBookings);


        } catch (PDOException $e) {
            // Handle potential errors more gracefully
            header("Content-Type: application/json");
            echo json_encode(array("success" => false, "message" => "Connection failed: " . $e->getMessage()));
        }


    }

}

?>