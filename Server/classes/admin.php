<?php
class Admin
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addDefaultAdmin()
    {
        try {
            $email = "admin@example.com";
            error_log($email);

            // Check if default admin exists
            $query = "SELECT COUNT(*) as count FROM admins WHERE email = :email";
            $query = $this->db->prepare($query);
            $query->bindParam(":email", $email);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);

            if ($result['count'] == 0) {
                // Insert default admin
                $password = password_hash('password1', PASSWORD_DEFAULT);
                $full_name = "John Smith";
                $insertQuery = "INSERT INTO admins (email, password, fullname) VALUES (:email, :password, :full_name)";
                $insertQuery = $this->db->prepare($insertQuery);
                $insertQuery->bindParam(":email", $email);
                $insertQuery->bindParam(":password", $password);
                $insertQuery->bindParam(":full_name", $full_name);
                $insertQuery->execute();
                header("Content-Type: application/json");
                echo json_encode(array("success" => true, "message" => "Default admin added."));
            } else {
                header("Content-Type: application/json");
                echo json_encode(array("success" => false, "message" => "Default admin already exists."));
            }
            // $statement = $this->db->query($query);
        } catch (PDOException $e) {
            header("Content-Type: application/json");
            echo json_encode(array("success" => false, "message" => "Connection failed: " . $e->getMessage()));
        }

    }

    public function adminLogin($email, $password)
    {
        try {
            $query = "SELECT * FROM admins WHERE email = :email";
            $query = $this->db->prepare($query);
            $query->bindParam(":email", $email);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_ASSOC);



            if ($user) {
                if (password_verify($password, $user["password"])) {
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
            echo json_encode(array("success" => false, "message" => "Connection failed: " . $e->getMessage()));
        }



    }

}

?>