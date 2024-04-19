<?php

require_once '../db.php';
require_once '../classes/booking.php';

$database = new Database();
$db = $database->getConnection();


$post_data = file_get_contents('php://input');
$form_data = json_decode($post_data, true);


// Extract date
$selectedDate = $form_data['selectedDate'];

//echo $selectedDate;

$timestamps = array();
$currentTimestamp = strtotime($selectedDate . 'T13:00:00');
$endTimestamp = strtotime($selectedDate . 'T21:00:00');
while ($currentTimestamp <= $endTimestamp) {
    $timestamps[] = date('Y-m-d H:i:s', $currentTimestamp);
    $currentTimestamp += 1800; // Add 30 minutes (1800 seconds)
}

$booking = new Booking($db);

$data = $booking->getBookingByTimestamps($timestamps);

return $data;
?>