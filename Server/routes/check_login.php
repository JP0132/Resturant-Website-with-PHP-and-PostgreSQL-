<?php
session_start();

if (isset($_SESSION["user_email"])) {
    echo json_encode(array("loggedIn" => true));
} else {
    echo json_encode(array("loggedIn" => false));
}

?>