<?php
session_start();

require_once '../db.php';
require_once '../classes/menu.php';

$database = new Database();
$db = $database->getConnection();

$menu = new Menu($db);

$items = $menu->getAllItems();
return $items;

?>