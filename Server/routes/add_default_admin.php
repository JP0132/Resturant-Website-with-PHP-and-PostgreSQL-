<?php
require_once '../db.php';
require_once '../classes/admin.php';

$database = new Database();
$db = $database->getConnection();

// echo "Hello, World!";
// print "Hello, World!";
// var_dump("email");

$admin = new Admin($db);

$data = $admin->addDefaultAdmin();
return $data;


?>