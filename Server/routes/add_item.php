<?php
session_start();

require_once '../db.php';
require_once '../classes/menu.php';

$database = new Database();
$db = $database->getConnection();

$menu = new Menu($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $course = $_POST['courseSelect'];

    $targetDirectory = "../uploads/";
    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $item_data = json_encode(
            array(
                "name" => $name,
                "description" => $description,
                "price" => $price,
                "course" => $course,
                "image" => $targetFile
            )
        );

        $data = $menu->addItem($item_data);
        return $data;




    } else {
        // File upload failed
        echo "Sorry, there was an error uploading your file.";
    }
}



?>