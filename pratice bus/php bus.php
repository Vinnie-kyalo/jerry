<?php
$servername = "localhost";
$username = "root"; // Default XAMPP/WAMP username
$password = "wanja 2024"; // Default XAMPP/WAMP password is empty
$dbname = "bus_reservation";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
