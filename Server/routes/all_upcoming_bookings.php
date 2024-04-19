<?php
require_once '../db.php';
require_once '../classes/booking.php';
require_once '../classes/user.php';

$database = new Database();
$db = $database->getConnection();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}




$booking = new Booking($db);
$data = $booking->getAllUpcomingBookings();

// Decode the JSON data into an associative array
$upcomingBookingsArray = json_decode($data, true);



$users = new User($db);
$bookingsWithNames = array();

if ($upcomingBookingsArray !== null && $upcomingBookingsArray['success']) {
    // Extract the upcoming bookings from the decoded array

    $upcomingBookings = $upcomingBookingsArray['upcomingBookings'];

    // Now you can work with the upcoming bookings array
    foreach ($upcomingBookings as $key => $bookingInfo) {

        $userId = $bookingInfo['user_id'];

        // Retrieve user information based on the user ID
        $userName = $users->getUserNameById($userId);

        // Store the user's name with the booking data
        $bookingInfo['fullname'] = $userName;
        $bookingsWithNames[] = $bookingInfo;

    }
} else {
    // Handle the case where fetching upcoming bookings failed
    // You can output an error message or take appropriate action
}

echo json_encode(array("success" => true, "upcoming_bookings" => $bookingsWithNames));
return json_encode(array("success" => true, "upcoming_bookings" => $bookingsWithNames));