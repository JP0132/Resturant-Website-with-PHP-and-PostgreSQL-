<?php
require_once '../db.php';
require_once '../classes/booking.php';

$database = new Database();
$db = $database->getConnection();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



$id = $_SESSION["user_id"];

$booking = new Booking($db);

$data = $booking->getUpcomingBookings($id);

return $data;

?>