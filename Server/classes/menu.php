<?php

class Menu
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllItems()
    {
        try {
            $query = "SELECT * FROM menu";
            $statement = $this->db->query($query);
            $menu_items = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $menu_items;
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return false;
        }
    }

    public function addItem($item_data_json)
    {

        try {
            $item_data = json_decode($item_data_json, true);


            $insertQuery = "INSERT INTO menu (name, description, price, images, courses_id) VALUES (:name, :description, :price, :image, :course)";
            $insertQuery = $this->db->prepare($insertQuery);
            $insertQuery->bindParam(":name", $item_data['name']);
            $insertQuery->bindParam(":description", $item_data['description']);
            $insertQuery->bindParam(":price", $item_data['price']);
            $insertQuery->bindParam(":image", $item_data['image']);
            $insertQuery->bindParam(":course", $item_data['course']);

            $insertQuery->execute();
            header("Content-Type: application/json");

            echo rtrim(json_encode(array("success" => true, "message" => "Added new menu item.")), "\r\n ");

        } catch (PDOException $e) {
            header("Content-Type: application/json");
            echo json_encode(array("success" => false, "message" => "Connection failed: " . $e->getMessage()));

        }
    }

}



?>