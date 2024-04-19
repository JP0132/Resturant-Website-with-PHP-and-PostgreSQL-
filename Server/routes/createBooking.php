<?php
session_start();

require_once '../db.php';
require_once '../classes/booking.php';

$database = new Database();
$db = $database->getConnection();


$post_data = file_get_contents('php://input');
$form_data = json_decode($post_data, true);

// Extract the data
$timestamp = $form_data['datetime'];


$booking = new Booking($db);

$data = $booking->createBooking($timestamp);

return $data;


?>