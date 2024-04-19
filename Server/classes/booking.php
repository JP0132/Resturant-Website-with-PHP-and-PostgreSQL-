<?php
class Booking
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function createBooking($timestamp)
    {
        try {

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $checkIfAvailable = "SELECT COUNT(*) as count FROM bookings WHERE booking_date = :timestamp";
            $checkIfAvailable = $this->db->prepare($checkIfAvailable);
            $checkIfAvailable->bindParam(":timestamp", $timestamp);
            $checkIfAvailable->execute();
            $result = $checkIfAvailable->fetch(PDO::FETCH_ASSOC);

            if ($result['count'] < 12) {
                $insertQuery = "INSERT INTO bookings (user_id, booking_date) VALUES (:userID, :booking_date)";
                $insertQuery = $this->db->prepare($insertQuery);
                $insertQuery->bindParam(":booking_date", $timestamp);
                $insertQuery->bindParam(":userID", $_SESSION["user_id"]);
                $insertQuery->execute();

                echo json_encode(array("success" => true, "message" => "Booking has been created!"));
            } else {
                header("Content-Type: application/json");
                echo json_encode(array("success" => true, "message" => "Booking is no longer available!"));
            }

        } catch (PDOException $e) {
            header("Content-Type: application/json");
            echo json_encode(array("success" => false, "message" => "Connection failed: " . $e->getMessage()));
        }
    }

    public function getBookingByTimestamps($timestamps)
    {
        try {
            // Prepare placeholders for timestamps
            $placeholders = rtrim(str_repeat('?,', count($timestamps)), ',');

            // Calculate the end timestamps for a 2-hour period for each provided timestamp
            $endTimestamps = array_map(function ($timestamp) {
                return date('Y-m-d H:i:s', strtotime($timestamp . ' +2 hours'));
            }, $timestamps);

            // Prepare and execute the query to fetch bookings within the provided timestamp ranges
            $sql = "SELECT COUNT(*) as count, booking_date FROM bookings WHERE booking_date IN ($placeholders) GROUP BY booking_date";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($timestamps);

            $availableSlots = array_fill_keys($timestamps, true);

            // Iterate over fetched results to determine availability
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $timestamp = $row['booking_date'];
                $count = $row['count'];

                // Check if count exceeds the limit (12 tables)
                if ($count >= 12) {
                    // Mark the timestamp as unavailable
                    $availableSlots[$timestamp] = false;
                }
            }

            // Return the availability status for each requested timestamp
            header("Content-Type: application/json");
            echo rtrim(json_encode(array("success" => true, "availability" => $availableSlots)), "\r\n ");


        } catch (PDOException $e) {
            // Handle potential errors more gracefully
            header("Content-Type: application/json");
            echo json_encode(array("success" => false, "message" => "Connection failed: " . $e->getMessage()));
        }


    }

    public function getPreviousBookings($id)
    {
        try {

            $currentDateTime = date("Y-m-d H:i:s");

            // Prepare and execute the query to fetch previous bookings
            $sql = "SELECT booking_date FROM bookings WHERE DATE(booking_date) < :currentDateTime AND user_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':currentDateTime', $currentDateTime);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $previousBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);


            // Return the availability status for each requested timestamp
            header("Content-Type: application/json");
            echo rtrim(json_encode(array("success" => true, "previousBookings" => $previousBookings)), "\r\n");
            //return array("success" => true, "previousBookings" => $previousBookings);


        } catch (PDOException $e) {
            // Handle potential errors more gracefully
            header("Content-Type: application/json");
            echo json_encode(array("success" => false, "message" => "Connection failed: " . $e->getMessage()));
        }

    }

    public function getAllUpcomingBookings()
    {
        try {

            date_default_timezone_set('Europe/London');
            $currentDateTime = date("Y-m-d H:i:s");


            // Prepare and execute the query to fetch previous bookings
            $sql = "SELECT * FROM bookings WHERE DATE(booking_date) >= :currentDateTime";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':currentDateTime', $currentDateTime);
            $stmt->execute();

            $upcomingBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);


            // Return the availability status for each requested timestamp

            return json_encode(array("success" => true, "upcomingBookings" => $upcomingBookings));
            //return array("success" => true, "previousBookings" => $previousBookings);


        } catch (PDOException $e) {
            // Handle potential errors more gracefully
            return json_encode(array("success" => false, "message" => "Connection failed: " . $e->getMessage()));
        }

    }

    public function getUpcomingBookings($id)
    {
        try {

            $currentDateTime = date("Y-m-d H:i:s");

            // Prepare and execute the query to fetch previous bookings
            $sql = "SELECT booking_date, booking_id FROM bookings WHERE DATE(booking_date) > :currentDateTime AND user_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':currentDateTime', $currentDateTime);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $upcomingBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);


            // Return the availability status for each requested timestamp

            echo rtrim(json_encode(array("success" => true, "upcomingBookings" => $upcomingBookings)), "\r\n");
            //return array("success" => true, "previousBookings" => $previousBookings);


        } catch (PDOException $e) {
            // Handle potential errors more gracefully
            header("Content-Type: application/json");
            echo json_encode(array("success" => false, "message" => "Connection failed: " . $e->getMessage()));
        }

    }

    public function deleteBookingByID($id)
    {
        try {

            // Prepare and execute the query to delete bookings
            $sql = "DELETE FROM bookings WHERE booking_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // Return success response
                header("Content-Type: application/json");
                echo rtrim(json_encode(array("success" => true, "message" => "Booking has been deleted")), "\r\n");
            } else {
                // Return error response if no rows were affected
                header("Content-Type: application/json");
                echo rtrim(json_encode(array("success" => true, "message" => "No booking found with the given ID")), "\r\n");
            }
            //return array("success" => true, "previousBookings" => $previousBookings);


        } catch (PDOException $e) {
            // Handle potential errors more gracefully
            header("Content-Type: application/json");
            echo json_encode(array("success" => false, "message" => "Connection failed: " . $e->getMessage()));
        }

    }
}
?>