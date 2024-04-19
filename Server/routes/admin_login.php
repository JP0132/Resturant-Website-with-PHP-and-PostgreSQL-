<?php
session_start();

require_once '../db.php';
require_once '../classes/admin.php';

$database = new Database();
$db = $database->getConnection();


$post_data = file_get_contents('php://input');
$form_data = json_decode($post_data, true);

// Extract email and password from the data
$email = $form_data['email'];
$password = $form_data['password'];


$admin = new Admin($db);

$data = $admin->adminLogin($email, $password);

// if ($data['success']) {
//     $_SESSION['admin_email'] = $email;
// }
return $data;


?>