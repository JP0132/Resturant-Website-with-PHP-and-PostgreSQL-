<?php
session_start();

require_once '../db.php';
require_once '../classes/user.php';

$database = new Database();
$db = $database->getConnection();


$post_data = file_get_contents('php://input');
$form_data = json_decode($post_data, true);

// Extract email and password from the data
$fullname = $form_data['fullname'];
$email = $form_data['email'];
$password = $form_data['password'];

$user = new User($db);

$data = $user->register($fullname, $email, $password);

// if ($data['success']) {
//     $_SESSION['admin_email'] = $email;
// }
return $data;


?>